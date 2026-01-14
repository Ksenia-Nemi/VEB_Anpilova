<?php
// Проверяем, установлено ли расширение mysqli
if (!extension_loaded('mysqli') && !function_exists('mysqli_connect')) {
    http_response_code(500);
    $php_ini_path = php_ini_loaded_file();
    $php_version = phpversion();
    $ext_dir = ini_get('extension_dir');
    
    die('<!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Ошибка: MySQLi не установлено</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; background: #f8f9fa; }
            .error-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 900px; margin: 50px auto; }
            h1 { color: #dc3545; }
            .info-block { background: #f8f9fa; padding: 15px; border-radius: 4px; margin: 15px 0; }
            .warning { background: #fff3cd; padding: 15px; margin: 15px 0; border-left: 4px solid #ffc107; border-radius: 4px; }
            code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: "Courier New", monospace; }
            ol { line-height: 1.8; }
            .path { background: #e7f3ff; padding: 10px; border-radius: 4px; margin: 10px 0; word-break: break-all; }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h1>❌ Расширение MySQLi не установлено</h1>
            <p>PHP не может найти расширение MySQLi, необходимое для подключения к базе данных.</p>
            
            <div class="info-block">
                <h3>📋 Информация о PHP:</h3>
                <p><strong>Версия PHP:</strong> ' . htmlspecialchars($php_version) . '</p>
                <p><strong>Путь к php.ini:</strong> ' . ($php_ini_path ? '<code>' . htmlspecialchars($php_ini_path) . '</code>' : '<span style="color:red">Не найден</span>') . '</p>
                <p><strong>Папка расширений:</strong> ' . ($ext_dir ? '<code>' . htmlspecialchars($ext_dir) . '</code>' : 'Не указано') . '</p>
            </div>
            
            <div class="warning">
                <h3>⚠️ Как исправить:</h3>
                ' . ($php_ini_path ? '
                <h4>Если это локальная установка (XAMPP, OpenServer и т.д.):</h4>
                <ol>
                    <li>Откройте файл php.ini по пути выше (правой кнопкой → "Открыть с помощью" → "Блокнот" от имени администратора)</li>
                    <li>Найдите строку: <code>;extension=mysqli</code> или <code>;extension=php_mysqli.dll</code></li>
                    <li>Уберите точку с запятой: <code>extension=mysqli</code></li>
                    <li>Сохраните файл</li>
                    <li>Перезапустите Apache/веб-сервер</li>
                    <li>Откройте файл <code>НАЙТИ_PHP_INI.php</code> для более подробных инструкций</li>
                </ol>
                ' : '') . '
                <h4>Если это удаленный хостинг (shared hosting):</h4>
                <ol>
                    <li>Обратитесь к администратору хостинга с просьбой включить расширение MySQLi</li>
                    <li>Или проверьте панель управления хостингом (cPanel, Plesk и т.д.) - там может быть возможность включить расширения</li>
                </ol>
                
                <h4>Быстрая диагностика:</h4>
                <ol>
                    <li>Откройте файл <code>phpinfo.php</code> в браузере для просмотра полной информации о PHP</li>
                    <li>Откройте файл <code>НАЙТИ_PHP_INI.php</code> для помощи в поиске php.ini</li>
                    <li>Проверьте файл <code>ВКЛЮЧИТЬ_MYSQLI.md</code> для подробной инструкции</li>
                </ol>
            </div>
            
            <div class="info-block">
                <h3>📚 Полезные файлы в проекте:</h3>
                <ul>
                    <li><code>НАЙТИ_PHP_INI.php</code> - поможет найти правильный php.ini</li>
                    <li><code>phpinfo.php</code> - полная информация о конфигурации PHP</li>
                    <li><code>test_mysqli.php</code> - проверка расширения MySQLi</li>
                    <li><code>ВКЛЮЧИТЬ_MYSQLI.md</code> - подробная инструкция</li>
                </ul>
            </div>
        </div>
    </body>
    </html>');
}

// Включаем отчет об ошибках mysqli (если функция доступна)
if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}

// Параметры подключения к базе данных
$DB_HOST = 'std-mysql';
$DB_USER = 'std_2741_pk2';
$DB_PASS = 'qwerty12345';
$DB_NAME = 'std_2741_pk2';

try {
    $db = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    
    // Проверяем соединение
    if ($db->connect_error) {
        throw new Exception('Ошибка подключения к базе данных: ' . $db->connect_error);
    }
    
    // Устанавливаем кодировку
    $db->set_charset('utf8mb4');
    
} catch (Exception $e) {
    http_response_code(500);
    echo '<!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Ошибка базы данных</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; background: #f8f9fa; }
            .error-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 800px; margin: 50px auto; }
            h1 { color: #dc3545; }
            pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow: auto; }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h1>Ошибка подключения к базе данных</h1>
            <p>' . htmlspecialchars($e->getMessage()) . '</p>
            <h3>Проверьте следующие моменты:</h3>
            <ul>
                <li>Сервер MySQL доступен по адресу: ' . htmlspecialchars($DB_HOST) . '</li>
                <li>База данных "' . htmlspecialchars($DB_NAME) . '" существует</li>
                <li>Пользователь "' . htmlspecialchars($DB_USER) . '" имеет доступ к базе</li>
                <li>Пароль указан верно</li>
            </ul>
            <p>Файл настройки: ' . __FILE__ . '</p>
            <pre>Хост: ' . htmlspecialchars($DB_HOST) . '
Пользователь: ' . htmlspecialchars($DB_USER) . '
База данных: ' . htmlspecialchars($DB_NAME) . '</pre>
        </div>
    </body>
    </html>';
    exit;
}
