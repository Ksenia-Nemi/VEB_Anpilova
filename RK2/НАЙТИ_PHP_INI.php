<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Найти php.ini</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f8f9fa; }
        .box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 900px; margin: 20px auto; }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .path { background: #f8f9fa; padding: 15px; border-radius: 4px; border-left: 4px solid #28a745; margin: 15px 0; font-family: 'Courier New', monospace; word-break: break-all; }
        .step { background: #e7f3ff; padding: 15px; margin: 10px 0; border-left: 4px solid #2196F3; border-radius: 4px; }
        .step h3 { margin-top: 0; color: #1976D2; }
        .warning { background: #fff3cd; padding: 15px; margin: 15px 0; border-left: 4px solid #ffc107; border-radius: 4px; }
        .success { background: #d4edda; padding: 15px; margin: 15px 0; border-left: 4px solid #28a745; border-radius: 4px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: 'Courier New', monospace; }
        ol { line-height: 1.8; }
        .copy-btn { background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; margin-left: 10px; }
        .copy-btn:hover { background: #0056b3; }
    </style>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Путь скопирован в буфер обмена!');
            });
        }
    </script>
</head>
<body>
    <div class="box">
        <h1>🔍 Поиск файла php.ini</h1>
        
        <?php
        $ini_file = php_ini_loaded_file();
        $ini_scanned = php_ini_scanned_files();
        $php_version = phpversion();
        $ext_dir = ini_get('extension_dir');
        ?>
        
        <div class="path">
            <strong>📍 Путь к используемому php.ini:</strong><br>
            <?php if ($ini_file): ?>
                <code style="font-size: 16px;"><?= htmlspecialchars($ini_file) ?></code>
                <button class="copy-btn" onclick="copyToClipboard('<?= htmlspecialchars($ini_file) ?>')">📋 Копировать</button>
            <?php else: ?>
                <span style="color: red;">❌ Файл php.ini не найден!</span>
            <?php endif; ?>
        </div>
        
        <div class="path">
            <strong>📂 Папка расширений (extension_dir):</strong><br>
            <code style="font-size: 16px;"><?= htmlspecialchars($ext_dir ?: 'Не указано') ?></code>
        </div>
        
        <div class="path">
            <strong>ℹ️ Версия PHP:</strong> <?= htmlspecialchars($php_version) ?>
        </div>
        
        <div class="warning">
            <h3>⚠️ ВАЖНО!</h3>
            <p>Это путь к файлу php.ini, который <strong>используется веб-сервером</strong> (Apache).</p>
            <p>Командная строка может использовать другой php.ini! Для веб-сервера важен именно этот файл.</p>
        </div>
        
        <?php if ($ini_file): ?>
            <div class="step">
                <h3>📝 Шаг 1: Откройте файл php.ini</h3>
                <ol>
                    <li>Скопируйте путь выше (нажмите кнопку "Копировать")</li>
                    <li>Откройте <strong>Проводник Windows</strong> (Win + E)</li>
                    <li>Вставьте путь в адресную строку и нажмите Enter</li>
                    <li><strong>ВАЖНО:</strong> Щелкните правой кнопкой мыши на файле php.ini → "Открыть с помощью" → "Блокнот" (или любой текстовый редактор)</li>
                    <li>Если система требует разрешения администратора - нажмите "Да"</li>
                </ol>
            </div>
            
            <div class="step">
                <h3>🔍 Шаг 2: Найдите строку с mysqli</h3>
                <ol>
                    <li>В открытом файле php.ini нажмите <strong>Ctrl + F</strong> (поиск)</li>
                    <li>Введите: <code>mysqli</code></li>
                    <li>Найдите строку, которая выглядит так:</li>
                </ol>
                <div style="background: #f4f4f4; padding: 10px; margin: 10px 0; border-radius: 4px;">
                    <code>;extension=mysqli</code><br>
                    или<br>
                    <code>;extension=php_mysqli.dll</code>
                </div>
            </div>
            
            <div class="step">
                <h3>✏️ Шаг 3: Включите расширение</h3>
                <ol>
                    <li>Убедитесь, что строка начинается с <strong>точки с запятой</strong> (<code>;</code>)</li>
                    <li>Удалите точку с запятой в начале строки</li>
                    <li>Должно получиться:</li>
                </ol>
                <div style="background: #f4f4f4; padding: 10px; margin: 10px 0; border-radius: 4px;">
                    <code>extension=mysqli</code><br>
                    или<br>
                    <code>extension=php_mysqli.dll</code>
                </div>
                <p><strong>💡 Совет:</strong> В некоторых версиях PHP 8+ используется просто <code>extension=mysqli</code> без .dll</p>
            </div>
            
            <div class="step">
                <h3>💾 Шаг 4: Сохраните файл</h3>
                <ol>
                    <li>Нажмите <strong>Ctrl + S</strong> для сохранения</li>
                    <li>Если система требует разрешения администратора - нажмите "Да"</li>
                </ol>
            </div>
            
            <div class="step">
                <h3>🔄 Шаг 5: Перезапустите веб-сервер</h3>
                <ol>
                    <li><strong>Для XAMPP:</strong>
                        <ul>
                            <li>Откройте XAMPP Control Panel</li>
                            <li>Нажмите "Stop" для Apache</li>
                            <li>Подождите 3-5 секунд</li>
                            <li>Нажмите "Start" для Apache</li>
                        </ul>
                    </li>
                    <li><strong>Для OpenServer:</strong>
                        <ul>
                            <li>Остановите сервер</li>
                            <li>Запустите сервер снова</li>
                        </ul>
                    </li>
                </ol>
            </div>
            
            <div class="step">
                <h3>✅ Шаг 6: Проверьте результат</h3>
                <ol>
                    <li>Откройте файл <code>test_mysqli.php</code> в браузере</li>
                    <li>Если видите "MySQLi расширение УСТАНОВЛЕНО" - всё готово! ✅</li>
                    <li>Если ошибка осталась - проверьте, что вы сохранили правильный файл php.ini</li>
                </ol>
            </div>
            
        <?php else: ?>
            <div class="warning">
                <h3>❌ Файл php.ini не найден!</h3>
                <p>Возможные причины:</p>
                <ul>
                    <li>PHP не установлен правильно</li>
                    <li>Используется другой способ запуска PHP</li>
                    <li>Это может быть удаленный хостинг (std-mysql)</li>
                </ul>
                <p>Если это удаленный хостинг, обратитесь к администратору хостинга для включения расширения MySQLi.</p>
            </div>
        <?php endif; ?>
        
        <?php if ($ini_scanned): ?>
            <div class="path" style="margin-top: 20px;">
                <strong>📁 Дополнительные файлы конфигурации:</strong><br>
                <code><?= htmlspecialchars($ini_scanned) ?></code>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 4px;">
            <h3>📚 Дополнительная информация</h3>
            <p>Подробная инструкция находится в файле <code>ВКЛЮЧИТЬ_MYSQLI.md</code></p>
            <p>Для проверки расширения откройте файл <code>test_mysqli.php</code></p>
        </div>
    </div>
</body>
</html>

