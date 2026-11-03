@echo off
REM Build a single-file XpertVA agent executable for Windows.
REM Run this on a Windows machine with Python 3.9+ installed.

echo Installing dependencies...
python -m pip install --upgrade pip
python -m pip install requests pywin32 psutil uiautomation pyinstaller

echo Building XpertVAAgent.exe...
pyinstaller --noconfirm --onefile --name XpertVAAgent ^
  --add-data "config.example.json;." ^
  xpertva_agent.py

echo.
echo Done. The executable is in the dist\ folder: dist\XpertVAAgent.exe
echo Place a filled-in config.json next to the .exe before running.
pause
