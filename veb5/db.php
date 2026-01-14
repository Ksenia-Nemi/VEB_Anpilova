<?php
// db.php - Подключение к базе данных в XAMPP
define('DB_HOST', 'localhost');     // Адрес сервера
define('DB_USER', 'root');          // Имя пользователя (по умолчанию в XAMPP)
define('DB_PASSWORD', '');          // Пароль (по умолчанию пустой в XAMPP)
define('DB_NAME', 'lab5_data');     // Имя базы данных

// Создаем подключение
$mysql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Проверяем соединение
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

// Устанавливаем кодировку
$mysql->set_charset("utf8");
?>