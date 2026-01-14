<?php
// insert.php - обработчик добавления данных в БД

// Подключаемся к базе данных
include "db.php";

// Проверяем, были ли отправлены данные из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем и очищаем данные из формы
    $term = mysqli_real_escape_string($mysql, trim($_POST['term']));
    $definition = mysqli_real_escape_string($mysql, trim($_POST['definition']));
    $category = mysqli_real_escape_string($mysql, trim($_POST['category']));
    $image_name = mysqli_real_escape_string($mysql, trim($_POST['image_name']));
    $image_filename = mysqli_real_escape_string($mysql, trim($_POST['image_filename']));
    
    // Проверяем обязательные поля
    if (empty($term) || empty($definition) || empty($category)) {
        header("Location: add.php?error=1");
        exit();
    }
    
    // Начинаем транзакцию для согласованности данных
    mysqli_begin_transaction($mysql);
    
    $success = true;
    $error_message = "";
    
    try {
        // Добавляем термин в таблицу terms
        $sql1 = "INSERT INTO `terms` (`term`, `definition`, `category`) 
                VALUES ('$term', '$definition', '$category')";
        
        if (!mysqli_query($mysql, $sql1)) {
            throw new Exception("Ошибка при добавлении термина: " . mysqli_error($mysql));
        }
        
        // Если указаны данные изображения, добавляем его в таблицу images
        if (!empty($image_name) && !empty($image_filename)) {
            // Проверяем, не существует ли уже такое изображение
            $check_sql = "SELECT id FROM `images` WHERE `filename` = '$image_filename'";
            $check_result = mysqli_query($mysql, $check_sql);
            
            if (mysqli_num_rows($check_result) == 0) {
                $sql2 = "INSERT INTO `images` (`name`, `filename`) 
                        VALUES ('$image_name', '$image_filename')";
                
                if (!mysqli_query($mysql, $sql2)) {
                    throw new Exception("Ошибка при добавлении изображения: " . mysqli_error($mysql));
                }
            }
        }
        
        // Если все запросы успешны, подтверждаем транзакцию
        mysqli_commit($mysql);
        
        // Перенаправляем на страницу добавления с сообщением об успехе
        header("Location: add.php?success=1");
        exit();
        
    } catch (Exception $e) {
        // Откатываем транзакцию в случае ошибки
        mysqli_rollback($mysql);
        $error_message = $e->getMessage();
        
        // Логируем ошибку (в реальном проекте лучше писать в лог-файл)
        error_log("Database error: " . $error_message);
        
        // Перенаправляем на страницу добавления с сообщением об ошибке
        header("Location: add.php?error=1");
        exit();
    }
    
    // Закрываем соединение с БД
    mysqli_close($mysql);
} else {
    // Если данные не были отправлены методом POST, перенаправляем на главную
    header("Location: index.php");
    exit();
}
?>