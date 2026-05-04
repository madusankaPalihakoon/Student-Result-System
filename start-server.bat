@echo off
cd /d %~dp0
echo Starting PHP server on http://localhost:8000
php -S localhost:8000
pause