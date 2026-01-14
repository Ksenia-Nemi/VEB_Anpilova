<?php
/**
 * Файл конфигурации для подключения к базе данных
 * Используется для подключения к MySQL через XAMPP
 */

// Параметры подключения к базе данных
define('DB_HOST', 'localhost');        // Хост базы данных (для XAMPP обычно localhost)
define('DB_USER', 'root');             // Имя пользователя MySQL (по умолчанию в XAMPP - root)
define('DB_PASS', '');                 // Пароль MySQL (по умолчанию в XAMPP пустой)
define('DB_NAME', 'shop_db');          // Имя базы данных

/**
 * Функция для подключения к базе данных
 * @return mysqli|false Объект подключения или false в случае ошибки
 */
function getDBConnection() {
    // Создаем подключение к базе данных
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Проверяем подключение
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }
    
    // Устанавливаем кодировку UTF-8 для корректной работы с русским языком
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

/**
 * Функция для безопасного выполнения SQL запросов
 * @param string $query SQL запрос
 * @param array $params Параметры для подготовленного запроса
 * @return mysqli_result|bool Результат запроса
 */
function executeQuery($query, $params = []) {
    $conn = getDBConnection();
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    
    if (!empty($params)) {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    
    return $result;
}

// Запуск сессии для работы с авторизацией
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Проверка авторизации пользователя
 * @return bool true если пользователь авторизован, иначе false
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Получение информации о текущем пользователе
 * @return array|false Массив с данными пользователя или false
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return false;
    }
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    
    return $user;
}
?>

