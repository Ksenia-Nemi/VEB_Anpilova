<?php
/**
 * Тестовый файл для проверки подключения к базе данных
 * Откройте в браузере: http://localhost/RKR2/test_connection.php
 */

require_once 'config.php';

echo "<!DOCTYPE html>";
echo "<html lang='ru'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Тест подключения к БД</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
    .success { color: green; background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .error { color: red; background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .info { background: #d1ecf1; padding: 15px; border-radius: 5px; margin: 10px 0; }
    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
    th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
    th { background-color: #667eea; color: white; }
</style>";
echo "</head>";
echo "<body>";

echo "<h1>Тест подключения к базе данных</h1>";

try {
    echo "<div class='info'>";
    echo "<strong>Параметры подключения:</strong><br>";
    echo "Хост: " . DB_HOST . "<br>";
    echo "Пользователь: " . DB_USER . "<br>";
    echo "База данных: " . DB_NAME . "<br>";
    echo "</div>";
    
    $conn = getDBConnection();
    echo "<div class='success'>✓ Подключение к базе данных успешно установлено!</div>";
    
    // Проверка таблиц
    echo "<h2>Найденные таблицы:</h2>";
    $tables = $conn->query("SHOW TABLES");
    $table_count = 0;
    echo "<table>";
    echo "<tr><th>№</th><th>Название таблицы</th><th>Количество записей</th></tr>";
    
    while ($row = $tables->fetch_array()) {
        $table_count++;
        $table_name = $row[0];
        $count_result = $conn->query("SELECT COUNT(*) as count FROM `$table_name`");
        $count = $count_result->fetch_assoc()['count'];
        echo "<tr><td>$table_count</td><td><strong>$table_name</strong></td><td>$count</td></tr>";
    }
    echo "</table>";
    
    if ($table_count == 0) {
        echo "<div class='error'>⚠ Таблицы не найдены! Необходимо импортировать database.sql</div>";
    } else {
        echo "<div class='success'>✓ Найдено таблиц: $table_count</div>";
    }
    
    // Проверка данных в таблице products
    echo "<h2>Проверка товаров:</h2>";
    $products = $conn->query("SELECT COUNT(*) as count FROM products");
    $product_count = $products->fetch_assoc()['count'];
    
    if ($product_count > 0) {
        echo "<div class='success'>✓ Товаров в базе: <strong>$product_count</strong></div>";
        
        // Показываем первые 3 товара
        $sample_products = $conn->query("SELECT id, name, price FROM products LIMIT 3");
        echo "<h3>Примеры товаров:</h3>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Название</th><th>Цена</th></tr>";
        while ($product = $sample_products->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $product['id'] . "</td>";
            echo "<td>" . htmlspecialchars($product['name']) . "</td>";
            echo "<td>" . number_format($product['price'], 2, '.', ' ') . " ₽</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='error'>⚠ Товары не найдены! Необходимо импортировать database.sql</div>";
    }
    
    // Проверка пользователей
    echo "<h2>Проверка пользователей:</h2>";
    $users = $conn->query("SELECT COUNT(*) as count FROM users");
    $user_count = $users->fetch_assoc()['count'];
    
    if ($user_count > 0) {
        echo "<div class='success'>✓ Пользователей в базе: <strong>$user_count</strong></div>";
    } else {
        echo "<div class='error'>⚠ Пользователи не найдены! Необходимо импортировать database.sql</div>";
    }
    
    // Проверка кодировки
    echo "<h2>Проверка кодировки:</h2>";
    $charset = $conn->query("SELECT @@character_set_database as charset");
    $charset_result = $charset->fetch_assoc();
    $current_charset = $charset_result['charset'];
    
    if ($current_charset == 'utf8mb4') {
        echo "<div class='success'>✓ Кодировка базы данных: <strong>$current_charset</strong> (правильно)</div>";
    } else {
        echo "<div class='error'>⚠ Кодировка базы данных: <strong>$current_charset</strong> (рекомендуется utf8mb4)</div>";
    }
    
    $conn->close();
    
    echo "<div class='success' style='margin-top: 30px;'>";
    echo "<h2>✓ Все проверки пройдены успешно!</h2>";
    echo "<p>База данных настроена правильно. Вы можете использовать сайт.</p>";
    echo "<p><a href='index.php' style='color: #667eea;'>Перейти на главную страницу →</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<h2>✗ Ошибка подключения!</h2>";
    echo "<p><strong>Сообщение:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Возможные причины:</strong></p>";
    echo "<ul>";
    echo "<li>MySQL не запущен в XAMPP</li>";
    echo "<li>База данных 'shop_db' не создана</li>";
    echo "<li>Неверные параметры подключения в config.php</li>";
    echo "<li>Пароль MySQL установлен, но не указан в config.php</li>";
    echo "</ul>";
    echo "<p><strong>Решение:</strong> См. файл ПОДКЛЮЧЕНИЕ_БД_XAMPP.md</p>";
    echo "</div>";
}

echo "</body>";
echo "</html>";
?>

