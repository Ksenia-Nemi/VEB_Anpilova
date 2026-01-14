@echo off
chcp 65001 >nul
echo ========================================
echo Запуск PHP сервера для формы обратной связи
echo ========================================
echo.

cd /d "%~dp0"

REM Проверяем наличие PHP
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo [ОШИБКА] PHP не найден в системе!
    echo.
    echo Установите PHP или используйте XAMPP/OpenServer
    echo Подробнее смотрите README.md
    echo.
    pause
    exit /b 1
)

echo PHP найден! Запускаю сервер...
echo.
echo Сервер будет доступен по адресу: http://localhost:8000
echo Откройте: http://localhost:8000/index.php
echo.
echo Нажмите Ctrl+C для остановки сервера
echo ========================================
echo.

php -S localhost:8000

pause



