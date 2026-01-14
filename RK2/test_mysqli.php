<?php
// Быстрая проверка MySQLi расширения
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Проверка MySQLi</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f8f9fa; }
        .box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 800px; margin: 50px auto; }
        .success { color: #28a745; font-weight: bold; font-size: 18px; }
        .error { color: #dc3545; font-weight: bold; font-size: 18px; }
        h1 { color: #333; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow: auto; }
        .info { margin-top: 20px; padding: 15px; background: #e7f3ff; border-left: 4px solid #2196F3; }
    </style>
</head>
<body>
    <div class="box">
        <h1>Проверка расширения MySQLi</h1>
        
        <?php if (function_exists('mysqli_connect')): ?>
            <p class="success">✓ MySQLi расширение УСТАНОВЛЕНО и работает!</p>
        <?php else: ?>
            <p class="error">✗ MySQLi расширение НЕ установлено или не включено.</p>
            <div class="info">
                <h3>Что делать:</h3>
                <ol>
                    <li>Откройте файл <code>php.ini</code> (обычно находится в папке установки PHP, например: <code>C:\xampp\php\php.ini</code>)</li>
                    <li>Найдите строку <code>;extension=mysqli</code> или <code>;extension=php_mysqli.dll</code></li>
                    <li>Уберите точку с запятой в начале строки: <code>extension=mysqli</code></li>
                    <li>Сохраните файл</li>
                    <li>Перезапустите Apache/XAMPP/OpenServer</li>
                    <li>Обновите эту страницу</li>
                </ol>
                <p>Подробная инструкция находится в файле <code>ВКЛЮЧИТЬ_MYSQLI.md</code></p>
            </div>
        <?php endif; ?>
        
        <div class="info">
            <h3>Информация о PHP:</h3>
            <pre>Версия PHP: <?= phpversion() ?>
Путь к php.ini: <?= php_ini_loaded_file() ?: 'Не найден' ?></pre>
        </div>
        
        <?php if (function_exists('mysqli_connect')): ?>
            <div class="info">
                <h3>Дополнительная информация:</h3>
                <p>Если расширение установлено, но всё равно возникают проблемы с подключением к базе данных, проверьте:</p>
                <ul>
                    <li>Параметры подключения в файле <code>db.php</code></li>
                    <li>Доступность сервера MySQL</li>
                    <li>Правильность имени базы данных, пользователя и пароля</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

