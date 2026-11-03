# XpertVA Monitoring Agent

A company-deployed desktop agent that records **which website is open in the
employee's active browser**, during **shift hours only**, and reports it to the
XpertVA portal. It appears in the portal's **Activity Monitor** alongside the
browser-extension data.

It is **disclosed monitoring**, not spyware:
- Shows the employee a one-time on-screen notice the first time it runs.
- No screenshots. No keylogging. Only the foreground browser tab.
- Nothing is recorded outside the configured shift window.

> **Before you deploy:** put your monitoring policy in writing and have staff
> acknowledge it, and only install on **company-owned** machines. Most
> jurisdictions require employees to be informed; some require consent. The
> agent's notice helps, but it is not a substitute for a signed policy. Confirm
> the rules for your region with your own legal/HR advisor.

## How it fits the portal

| Piece | Location |
|-------|----------|
| Agent API | `POST /api/agent/activity`, `GET /api/agent/config`, `POST /api/agent/consent` |
| Auth | per-employee token in the `X-Agent-Token` header |
| Get tokens | Portal → **Activity Monitor → Manage Agents** (super admin) |
| See results | Portal → **Activity Monitor** (filter by employee + date) |
| Shift window | Portal → **Settings** (shift start/end) — the agent obeys it |

## 1. Provision a token
Log in as super admin → **Activity Monitor** → **Manage Agents**. Copy the token
for the employee whose PC you are setting up. Also confirm the **API base URL**
shown there is your real portal URL (set `APP_URL` in the portal `.env` if it
still says `http://localhost`).

## 2. Configure
On the employee PC, copy `config.example.json` to `config.json` next to the agent
and fill it in:

```json
{
  "server_url": "https://xpertva.com",
  "token": "the-employees-agent-token",
  "idle_threshold_seconds": 60
}
```

## 3a. Run from Python (testing / macOS)
```bash
pip install -r requirements.txt
# macOS also: grant Terminal "Accessibility" + "Automation" in System Settings > Privacy
python xpertva_agent.py
```

## 3b. Build a Windows .exe (deployment)
On a Windows machine with Python 3.9+:
```bat
build_windows.bat
```
This produces `dist\XpertVAAgent.exe`. Put a filled-in `config.json` in the same
folder as the .exe and run it.

## 4. Auto-start during shifts (Windows)
Use Task Scheduler so it launches at logon (it self-limits to shift hours):
```
schtasks /Create /TN "XpertVA Agent" /TR "C:\XpertVA\XpertVAAgent.exe" /SC ONLOGON /RL LIMITED
```
Keep `XpertVAAgent.exe` and `config.json` together in `C:\XpertVA\`.

## What each sample contains
`app_name` (browser), `window_title` (tab title), `url` (active tab), plus
`active_time`/`idle_time` for the interval. Off-shift samples are refused by the
server, so nothing outside working hours is stored.

## Notes on URL capture
URLs are read from the browser's address bar via OS UI automation
(`uiautomation` on Windows; AppleScript on macOS). If that can't read a given
browser, the agent still reports the window/tab **title**, which usually names
the site or video. The browser extension in `../extension/` remains the most
reliable source for Chrome and can run alongside the agent.
