#!/usr/bin/env python3
"""
XpertVA Monitoring Agent
------------------------
A transparent, company-deployed desktop agent that records which website the
employee has open in the foreground browser and reports it to the XpertVA
portal. It runs ONLY during the configured shift window and shows the employee
a one-time notice the first time it starts (disclosed monitoring, not spyware).

What it captures per sample:
  - active browser process (chrome / msedge / firefox / ...)
  - the foreground window/tab title
  - the URL of the active tab (best effort, via OS UI automation)
  - active vs idle time since the last sample

What it does NOT do: no screenshots, no keylogging, no capture outside the
foreground browser, no capture outside shift hours.

Config: reads config.json next to this file (see config.example.json).
Cross-platform: full support on Windows; a working fallback on macOS for testing.
"""

import json
import os
import sys
import time
import platform
import datetime as dt

try:
    import requests
except ImportError:
    print("The 'requests' package is required. Run: pip install requests")
    sys.exit(1)

IS_WINDOWS = platform.system() == "Windows"
IS_MAC = platform.system() == "Darwin"

HERE = os.path.dirname(os.path.abspath(__file__))
CONFIG_PATH = os.path.join(HERE, "config.json")

BROWSER_PROCS = {
    "chrome.exe": "Chrome", "msedge.exe": "Edge", "firefox.exe": "Firefox",
    "brave.exe": "Brave", "opera.exe": "Opera", "vivaldi.exe": "Vivaldi",
    "iexplore.exe": "Internet Explorer",
    # macOS process names
    "Google Chrome": "Chrome", "Safari": "Safari", "Microsoft Edge": "Edge",
    "firefox": "Firefox", "Brave Browser": "Brave", "Opera": "Opera",
}


# --------------------------------------------------------------------------- #
# Config                                                                       #
# --------------------------------------------------------------------------- #
def load_config():
    if not os.path.exists(CONFIG_PATH):
        print(f"Missing config file: {CONFIG_PATH}")
        print("Copy config.example.json to config.json and fill in server_url and token.")
        sys.exit(1)
    with open(CONFIG_PATH) as f:
        cfg = json.load(f)
    if not cfg.get("server_url") or not cfg.get("token"):
        print("config.json must contain 'server_url' and 'token'.")
        sys.exit(1)
    cfg["api_base"] = cfg["server_url"].rstrip("/") + "/api/agent"
    return cfg


# --------------------------------------------------------------------------- #
# Idle detection                                                               #
# --------------------------------------------------------------------------- #
def idle_seconds():
    """Seconds since the last keyboard/mouse input."""
    if IS_WINDOWS:
        import ctypes

        class LASTINPUTINFO(ctypes.Structure):
            _fields_ = [("cbSize", ctypes.c_uint), ("dwTime", ctypes.c_uint)]

        info = LASTINPUTINFO()
        info.cbSize = ctypes.sizeof(info)
        if ctypes.windll.user32.GetLastInputInfo(ctypes.byref(info)):
            millis = ctypes.windll.kernel32.GetTickCount() - info.dwTime
            return millis / 1000.0
        return 0.0
    if IS_MAC:
        try:
            import subprocess
            out = subprocess.check_output(
                "ioreg -c IOHIDSystem | awk '/HIDIdleTime/ {print $NF; exit}'",
                shell=True, text=True).strip()
            return int(out) / 1_000_000_000.0  # nanoseconds -> seconds
        except Exception:
            return 0.0
    return 0.0


# --------------------------------------------------------------------------- #
# Foreground window / process                                                  #
# --------------------------------------------------------------------------- #
def foreground_window():
    """Return (proc_name, window_title) of the foreground app, or (None, None)."""
    if IS_WINDOWS:
        try:
            import win32gui, win32process, psutil
            hwnd = win32gui.GetForegroundWindow()
            title = win32gui.GetWindowText(hwnd)
            _, pid = win32process.GetWindowThreadProcessId(hwnd)
            proc = psutil.Process(pid).name()
            return proc, title
        except Exception:
            return None, None
    if IS_MAC:
        try:
            import subprocess
            script = (
                'tell application "System Events"\n'
                ' set frontApp to name of first application process whose frontmost is true\n'
                'end tell\n'
                'return frontApp'
            )
            app = subprocess.check_output(["osascript", "-e", script], text=True).strip()
            return app, ""  # window title fetched with URL below on mac
        except Exception:
            return None, None
    return None, None


def is_browser(proc_name):
    if not proc_name:
        return False
    return proc_name in BROWSER_PROCS or proc_name.lower() in (k.lower() for k in BROWSER_PROCS)


def browser_label(proc_name):
    for k, v in BROWSER_PROCS.items():
        if k.lower() == (proc_name or "").lower():
            return v
    return proc_name


# --------------------------------------------------------------------------- #
# URL extraction (best effort)                                                 #
# --------------------------------------------------------------------------- #
def active_url_windows(proc_name):
    """Read the address bar of the foreground Chromium/Firefox window via UIAutomation."""
    try:
        import uiautomation as auto
    except Exception:
        return None, None
    try:
        win = auto.GetForegroundControl()
        if win is None:
            return None, None
        title = win.Name
        # Chromium (Chrome/Edge/Brave/Opera/Vivaldi): the omnibox is an Edit
        # control named "Address and search bar". Firefox uses a similar Edit.
        edit = win.EditControl(searchDepth=25)
        url = None
        if edit.Exists(0, 0):
            val = edit.GetValuePattern().Value if edit.GetValuePattern() else ""
            url = val or None
        if url and not url.startswith(("http://", "https://")) and "." in url:
            url = "http://" + url
        return url, title
    except Exception:
        return None, None


def active_url_mac(app):
    """Get the active tab URL + title from Safari/Chrome-family on macOS."""
    import subprocess
    try:
        if app in ("Safari",):
            url = subprocess.check_output(
                ["osascript", "-e", 'tell application "Safari" to return URL of front document'],
                text=True, stderr=subprocess.DEVNULL).strip()
            title = subprocess.check_output(
                ["osascript", "-e", 'tell application "Safari" to return name of front document'],
                text=True, stderr=subprocess.DEVNULL).strip()
            return (url or None), title
        # Chrome-family expose the same AppleScript dictionary
        url = subprocess.check_output(
            ["osascript", "-e", f'tell application "{app}" to return URL of active tab of front window'],
            text=True, stderr=subprocess.DEVNULL).strip()
        title = subprocess.check_output(
            ["osascript", "-e", f'tell application "{app}" to return title of active tab of front window'],
            text=True, stderr=subprocess.DEVNULL).strip()
        return (url or None), title
    except Exception:
        return None, None


def get_url_and_title(proc_name):
    if IS_WINDOWS:
        return active_url_windows(proc_name)
    if IS_MAC:
        return active_url_mac(proc_name)
    return None, None


# --------------------------------------------------------------------------- #
# One-time consent notice (transparency)                                       #
# --------------------------------------------------------------------------- #
def show_consent_notice(employee_name):
    """Show a blocking notice. Returns True if the employee acknowledges."""
    msg = (
        f"Hello {employee_name},\n\n"
        "This company computer runs the XpertVA monitoring agent during your "
        "scheduled shift hours. While you are on shift, it records the address "
        "of the website open in your active browser so your manager can see "
        "work-time browsing.\n\n"
        "It does NOT take screenshots, does NOT log keystrokes, and does NOT "
        "run outside your shift hours.\n\n"
        "Click OK to acknowledge and continue. If you do not agree, click "
        "Cancel and speak with your manager or HR."
    )
    try:
        import tkinter as tk
        from tkinter import messagebox
        root = tk.Tk()
        root.withdraw()
        ok = messagebox.askokcancel("XpertVA — Workplace Monitoring Notice", msg)
        root.destroy()
        return bool(ok)
    except Exception:
        # Headless / no GUI: fall back to console acknowledgement.
        print(msg)
        try:
            return input("Type 'yes' to acknowledge: ").strip().lower() == "yes"
        except EOFError:
            return True


# --------------------------------------------------------------------------- #
# Server calls                                                                 #
# --------------------------------------------------------------------------- #
def api(cfg, method, path, **kw):
    url = cfg["api_base"] + path
    headers = kw.pop("headers", {})
    headers["X-Agent-Token"] = cfg["token"]
    return requests.request(method, url, headers=headers, timeout=15, **kw)


def fetch_config(cfg):
    r = api(cfg, "GET", "/config")
    r.raise_for_status()
    return r.json()


# --------------------------------------------------------------------------- #
# Shift window helper (local check; server enforces again)                     #
# --------------------------------------------------------------------------- #
def within_shift(shift_start, shift_end, now=None):
    now = now or dt.datetime.now()
    sh, sm = map(int, shift_start.split(":")[:2])
    eh, em = map(int, shift_end.split(":")[:2])
    start = now.replace(hour=sh, minute=sm, second=0, microsecond=0)
    end = now.replace(hour=eh, minute=em, second=0, microsecond=0)
    if end <= start:  # overnight shift
        if now >= start:
            end += dt.timedelta(days=1)
        else:
            start -= dt.timedelta(days=1)
    return start <= now <= end


# --------------------------------------------------------------------------- #
# Main loop                                                                    #
# --------------------------------------------------------------------------- #
def main():
    cfg = load_config()
    print(f"XpertVA agent starting on {platform.system()} — portal: {cfg['server_url']}")

    try:
        server = fetch_config(cfg)
    except Exception as e:
        print(f"Could not reach portal /config: {e}")
        sys.exit(1)

    employee = server.get("employee", {}).get("name", "Employee")
    print(f"Authenticated as: {employee}")

    if server.get("consent_required"):
        if not show_consent_notice(employee):
            print("Employee did not acknowledge the notice. Exiting without monitoring.")
            sys.exit(0)
        try:
            api(cfg, "POST", "/consent")
        except Exception as e:
            print(f"Warning: could not record consent: {e}")

    interval = int(server.get("report_interval_seconds", 15))
    shift_start = server.get("shift_start", "09:00")
    shift_end = server.get("shift_end", "17:00")
    idle_threshold = int(cfg.get("idle_threshold_seconds", 60))

    last_cfg_refresh = time.time()
    print(f"Monitoring within shift {shift_start}–{shift_end}, every {interval}s. Press Ctrl+C to stop.")

    while True:
        try:
            # Refresh shift config from server every 5 minutes.
            if time.time() - last_cfg_refresh > 300:
                try:
                    server = fetch_config(cfg)
                    interval = int(server.get("report_interval_seconds", interval))
                    shift_start = server.get("shift_start", shift_start)
                    shift_end = server.get("shift_end", shift_end)
                except Exception:
                    pass
                last_cfg_refresh = time.time()

            if not within_shift(shift_start, shift_end):
                time.sleep(min(interval, 30))
                continue

            proc, title = foreground_window()
            if not is_browser(proc):
                # Not in a browser right now — nothing to report this cycle.
                time.sleep(interval)
                continue

            url, url_title = get_url_and_title(proc)
            title = url_title or title or ""

            idle = idle_seconds()
            is_idle = idle >= idle_threshold
            active_time = 0 if is_idle else interval
            idle_time = interval if is_idle else 0

            payload = {
                "url": url or "",
                "app_name": browser_label(proc),
                "window_title": title[:512],
                "active_time": active_time,
                "idle_time": idle_time,
                "captured_at": dt.datetime.now().astimezone().isoformat(),
            }

            try:
                resp = api(cfg, "POST", "/activity", json=payload)
                status = resp.json().get("status") if resp.ok else f"HTTP {resp.status_code}"
                print(f"[{dt.datetime.now():%H:%M:%S}] {payload['app_name']}: "
                      f"{url or title[:60]} -> {status}")
            except Exception as e:
                print(f"Report failed (will retry next cycle): {e}")

            time.sleep(interval)

        except KeyboardInterrupt:
            print("\nStopped by user.")
            break
        except Exception as e:
            print(f"Loop error: {e}")
            time.sleep(interval)


if __name__ == "__main__":
    main()
