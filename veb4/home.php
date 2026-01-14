<?php
// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_submitted'])) {
    
    // Проверяем обязательные поля
    if (empty($_POST['fio']) || empty($_POST['email']) || empty($_POST['message']) || empty($_POST['consent'])) {
        // Если обязательные поля не заполнены, возвращаем с ошибкой
        $returnParams = http_build_query([
            'error' => 'empty_fields',
            'fio' => $_POST['fio'] ?? '',
            'email' => $_POST['email'] ?? '',
            'source' => $_POST['source'] ?? '',
            'topic' => $_POST['topic'] ?? '',

        ]);
        header('Location: index.php?' . $returnParams);
        exit();
    }
    
    // Получаем данные из POST параметров
    $fio = isset($_POST['fio']) ? htmlspecialchars($_POST['fio']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
    $topic = isset($_POST['topic']) ? htmlspecialchars($_POST['topic']) : '';
    $source = isset($_POST['source']) ? htmlspecialchars($_POST['source']) : '';
    
    // Обработка файла
    $fileName = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = htmlspecialchars($_FILES['file']['name']);
        // Здесь можно добавить сохранение файла на сервер
        // move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $fileName);
    }

    // Формируем параметры для возврата к форме (ВСЕ данные включая сообщение)
    $returnParams = http_build_query([
        'fio' => $fio,
        'email' => $email,
        'source' => $source,
        'topic' => $topic,
    ]);

    $pageTitle = "Ответ на обращение";
    
} else {
    // Если форма не отправлена - перенаправляем на главную с ошибкой
    header('Location: index.php?error=direct_access');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #27ae60;
            margin-bottom: 30px;
        }
        .response-item {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #3498db;
            border-radius: 4px;
        }
        .response-item strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 8px;
        }
        .response-item p {
            color: #555;
            line-height: 1.6;
        }
        .message-box {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 4px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .file-info {
            color: #7f8c8d;
            font-style: italic;
        }
        .file-present {
            color: #27ae60;
            font-weight: bold;
        }
        .file-absent {
            color: #e74c3c;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2980b9;
        }
        .btn-container {
            text-align: center;
        }
        .success-notice {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-notice">
            ✅ Форма успешно отправлена!
        </div>
        
        <h1>✓ Ваше обращение принято!</h1>
        
        <div class="response-item">
            <strong>ФИО:</strong>
            <p><?php echo $fio; ?></p>
        </div>

        <div class="response-item">
            <strong>E-mail:</strong>
            <p><?php echo $email; ?></p>
        </div>

        <div class="response-item">
            <strong>Тема обращения:</strong>
            <p><?php echo !empty($topic) ? $topic : 'Не указана'; ?></p>
        </div>

        <div class="response-item">
            <strong>Источник информации:</strong>
            <p><?php echo !empty($source) ? $source : 'Не указан'; ?></p>
        </div>

        <div class="response-item">
            <strong>Текст обращения:</strong>
            <div class="message-box"><?php echo $message; ?></div>
        </div>

        <?php if (!empty($fileName)): ?>
        <div class="response-item">
            <strong>Прикрепленный файл:</strong>
            <p class="file-info file-present"><?php echo $fileName; ?></p>
        </div>
        <?php else: ?>
        <div class="response-item">
            <strong>Прикрепленный файл:</strong>
            <p class="file-info file-absent">Файл не был прикреплен</p>
        </div>
        <?php endif; ?>

        <div class="btn-container">
            <a href="index.php?<?php echo $returnParams; ?>" class="btn">Заполнить снова</a>
        </div>
    </div>
</body>
</html>

