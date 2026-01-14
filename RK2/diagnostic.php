<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Диагностика системы</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f8f9fa; }
        .box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 1000px; margin: 20px auto; }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .status { padding: 15px; margin: 15px 0; border-radius: 4px; border-left: 4px solid; }
        .success { background: #d4edda; border-color: #28a745; color: #155724; }
        .error { background: #f8d7da; border-color: #dc3545; color: #721c24; }
        .warning { background: #fff3cd; border-color: #ffc107; color: #856404; }
        .info { background: #d1ecf1; border-color: #17a2b8; color: #0c5460; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: "Courier New", monospace; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow: auto; border: 1px solid #dee2e6; }
        .step { background: #e7f3ff; padding: 15px; margin: 10px 0; border-left: 4px solid #2196F3; border-radius: 4px; }
        .step h3 { margin-top: 0; color: #1976D2; }
        ol, ul { line-height: 1.8; }
    </style>
</head>
<body>
    <div class="box">
        <h1>🔍 Диагностика системы</h1>
        
        <?php
        // Проверка MySQLi
        $mysqli_loaded = extension_loaded('mysqli');
        $mysqli_function = function_exists('mysqli_connect');
        $mysqli_available = $mysqli_loaded || $mysqli_function;
        
        // Информация о PHP
        $php_version = phpversion();
        $php_ini_path = php_ini_loaded_file();
        $php_ini_scanned = php_ini_scanned_files();
        $ext_dir = ini_get('extension_dir');
        
        // Проверка файлов
        $has_phpinfo = file_exists(__DIR__ . '/phpinfo.php');
        $has_find_ini = file_exists(__DIR__ . '/НАЙТИ_PHP_INI.php');
        $has_test = file_exists(__DIR__ . '/test_mysqli.php');
        ?>
        
        <!-- Статус MySQLi -->
        <div class="status <?= $mysqli_available ? 'success' : 'error' ?>">
            <h2><?= $mysqli_available ? '✅' : '❌' ?> Расширение MySQLi: <?= $mysqli_available ? 'ДОСТУПНО' : 'НЕ ДОСТУПНО' ?></h2>
            <?php if ($mysqli_available): ?>
                <p>Отлично! Расширение MySQLi установлено и работает. Проблема может быть в подключении к базе данных.</p>
            <?php else: ?>
                <p><strong>Проблема:</strong> Расширение MySQLi не установлено или не включено в PHP.</p>
            <?php endif; ?>
            
            <pre>extension_loaded('mysqli'): <?= $mysqli_loaded ? 'true' : 'false' ?>
function_exists('mysqli_connect'): <?= $mysqli_function ? 'true' : 'false' ?></pre>
        </div>
        
        <!-- Информация о PHP -->
        <div class="status info">
            <h2>📋 Информация о PHP</h2>
            <ul>
                <li><strong>Версия PHP:</strong> <?= htmlspecialchars($php_version) ?></li>
                <li><strong>Путь к php.ini:</strong> 
                    <?php if ($php_ini_path): ?>
                        <code><?= htmlspecialchars($php_ini_path) ?></code>
                    <?php else: ?>
                        <span style="color: red;">❌ Не найден</span>
                    <?php endif; ?>
                </li>
                <li><strong>Папка расширений:</strong> 
                    <?php if ($ext_dir): ?>
                        <code><?= htmlspecialchars($ext_dir) ?></code>
                    <?php else: ?>
                        <span style="color: orange;">⚠ Не указано</span>
                    <?php endif; ?>
                </li>
                <?php if ($php_ini_scanned): ?>
                    <li><strong>Дополнительные ini-файлы:</strong> <code><?= htmlspecialchars($php_ini_scanned) ?></code></li>
                <?php endif; ?>
            </ul>
        </div>
        
        <?php if (!$mysqli_available): ?>
            <!-- Инструкции по исправлению -->
            <div class="status warning">
                <h2>⚠️ Как исправить проблему с MySQLi</h2>
                
                <?php if ($php_ini_path): ?>
                    <div class="step">
                        <h3>📝 Шаг 1: Откройте файл php.ini</h3>
                        <ol>
                            <li>Скопируйте путь к php.ini из информации выше</li>
                            <li>Откройте <strong>Проводник Windows</strong> (Win + E)</li>
                            <li>Вставьте путь в адресную строку и нажмите Enter</li>
                            <li><strong>ВАЖНО:</strong> Щелкните правой кнопкой на файле <code>php.ini</code></li>
                            <li>Выберите "Открыть с помощью" → "Блокнот" (или любой текстовый редактор)</li>
                            <li>Если система спрашивает про разрешения администратора - нажмите "Да"</li>
                        </ol>
                    </div>
                    
                    <div class="step">
                        <h3>🔍 Шаг 2: Найдите строку с mysqli</h3>
                        <ol>
                            <li>В открытом файле php.ini нажмите <strong>Ctrl + F</strong> (поиск)</li>
                            <li>Введите: <code>mysqli</code></li>
                            <li>Найдите строку, которая выглядит так:</li>
                        </ol>
                        <pre>;extension=mysqli</pre>
                        <p>Или:</p>
                        <pre>;extension=php_mysqli.dll</pre>
                    </div>
                    
                    <div class="step">
                        <h3>✏️ Шаг 3: Включите расширение</h3>
                        <ol>
                            <li>Убедитесь, что строка начинается с <strong>точки с запятой</strong> (<code>;</code>)</li>
                            <li>Удалите точку с запятой в начале строки</li>
                            <li>Должно получиться:</li>
                        </ol>
                        <pre>extension=mysqli</pre>
                        <p><strong>Примечание:</strong> В PHP 8+ может быть просто <code>extension=mysqli</code> без .dll</p>
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
                                    <li>Остановите сервер (правой кнопкой на иконке в трее → "Остановить")</li>
                                    <li>Запустите сервер снова</li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                    
                    <div class="step">
                        <h3>✅ Шаг 6: Проверьте результат</h3>
                        <ol>
                            <li>Обновите эту страницу (F5 или Ctrl + R)</li>
                            <li>Если видите зеленый статус "✅ Расширение MySQLi: ДОСТУПНО" - всё готово!</li>
                        </ol>
                    </div>
                    
                <?php else: ?>
                    <div class="status error">
                        <h3>❌ Файл php.ini не найден!</h3>
                        <p>Это может означать, что:</p>
                        <ul>
                            <li>PHP не установлен правильно</li>
                            <li>Используется удаленный хостинг (не локальный сервер)</li>
                            <li>Используется нестандартная установка PHP</li>
                        </ul>
                        <p><strong>Если это удаленный хостинг:</strong> Обратитесь к администратору хостинга с просьбой включить расширение MySQLi.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Если MySQLi доступен, проверяем подключение к БД -->
            <div class="status info">
                <h2>🔌 Проверка подключения к базе данных</h2>
                <?php
                try {
                    @require_once __DIR__ . '/db.php';
                    if (isset($db) && ($db instanceof mysqli || (is_object($db) && method_exists($db, 'query')))) {
                        echo '<p>✅ Подключение к базе данных успешно!</p>';
                    } else {
                        echo '<p>⚠️ Проверьте настройки подключения в файле <code>db.php</code></p>';
                    }
                } catch (Exception $e) {
                    echo '<p>❌ Ошибка подключения: ' . htmlspecialchars($e->getMessage()) . '</p>';
                }
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Полезные файлы -->
        <div class="status info">
            <h2>📚 Полезные файлы в проекте</h2>
            <ul>
                <?php if ($has_find_ini): ?>
                    <li>✅ <code>НАЙТИ_PHP_INI.php</code> - поможет найти правильный php.ini</li>
                <?php else: ?>
                    <li>❌ <code>НАЙТИ_PHP_INI.php</code> - файл не найден</li>
                <?php endif; ?>
                
                <?php if ($has_phpinfo): ?>
                    <li>✅ <code>phpinfo.php</code> - полная информация о конфигурации PHP</li>
                <?php else: ?>
                    <li>❌ <code>phpinfo.php</code> - файл не найден</li>
                <?php endif; ?>
                
                <?php if ($has_test): ?>
                    <li>✅ <code>test_mysqli.php</code> - проверка расширения MySQLi</li>
                <?php else: ?>
                    <li>❌ <code>test_mysqli.php</code> - файл не найден</li>
                <?php endif; ?>
                
                <li>📄 <code>ВКЛЮЧИТЬ_MYSQLI.md</code> - подробная инструкция</li>
            </ul>
        </div>
        
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 4px; text-align: center;">
            <p><strong>Обновите эту страницу (F5) после внесения изменений в php.ini и перезапуска веб-сервера</strong></p>
        </div>
    </div>
</body>
</html>

