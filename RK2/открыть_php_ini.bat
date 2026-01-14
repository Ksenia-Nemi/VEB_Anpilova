@echo off
chcp 65001 >nul
echo ===================================
echo Открытие файла php.ini
echo ===================================
echo.
echo Файл: C:\PHP\php.ini
echo.
echo Открываю файл в Блокноте...
echo Если потребуются права администратора - нажмите "Да"
echo.
notepad "C:\PHP\php.ini"
echo.
echo Файл должен быть открыт в Блокноте.
echo.
echo После редактирования:
echo 1. Найдите строку: ;extension=mysqli
echo 2. Уберите точку с запятой: extension=mysqli
echo 3. Сохраните файл (Ctrl+S)
echo 4. Перезапустите Apache в XAMPP
echo.
pause

