<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление нового термина - XAMPP</title>
    <style>
        /* Стили такие же как в index.php */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        h1 {
            color: #2c3e50;
            font-size: 2em;
            margin-bottom: 10px;
        }
        
        .form-container {
            margin: 20px 0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input:focus, textarea:focus, select:focus {
            border-color: #3498db;
            outline: none;
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }
        
        .btn {
            flex: 1;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .btn-submit {
            background: #2ecc71;
            color: white;
        }
        
        .btn-submit:hover {
            background: #27ae60;
            transform: translateY(-2px);
        }
        
        .btn-back {
            background: #95a5a6;
            color: white;
        }
        
        .btn-back:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }
        
        .message {
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info-box {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 0.9em;
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✏️ Добавление нового термина</h1>
            <p style="color: #7f8c8d;">Заполните форму для добавления данных в базу</p>
        </div>
        
        <?php
        // Проверяем, были ли переданы параметры успешного добавления
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<div class="message success">✅ Термин успешно добавлен в базу данных!</div>';
        }
        
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<div class="message error">❌ Ошибка при добавлении термина. Пожалуйста, попробуйте снова.</div>';
        }
        ?>
        
        <div class="info-box">
            <strong>💡 Информация:</strong> Для добавления изображения сначала загрузите файл в папку img/, 
            а затем укажите его имя в форме ниже.
        </div>
        
        <div class="form-container">
            <form action="insert.php" method="POST">
                <div class="form-group">
                    <label for="term">Термин:</label>
                    <input type="text" id="term" name="term" required 
                           placeholder="Например: PHP, MySQL, HTML...">
                </div>
                
                <div class="form-group">
                    <label for="definition">Определение:</label>
                    <textarea id="definition" name="definition" required 
                              placeholder="Дайте подробное определение термина..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="category">Категория:</label>
                    <select id="category" name="category" required>
                        <option value="">-- Выберите категорию --</option>
                        <option value="Программирование">Программирование</option>
                        <option value="Базы данных">Базы данных</option>
                        <option value="Веб-разработка">Веб-разработка</option>
                        <option value="Сети">Сети</option>
                        <option value="Безопасность">Безопасность</option>
                        <option value="Операционные системы">Операционные системы</option>
                        <option value="Алгоритмы">Алгоритмы</option>
                        <option value="Другое">Другое</option>
                    </select>
                </div>
                
                <h3 style="margin-top: 30px;">🖼️ Изображение (опционально)</h3>
                
                <div class="form-group">
                    <label for="image_name">Название изображения:</label>
                    <input type="text" id="image_name" name="image_name" 
                           placeholder="Например: Логотип PHP">
                </div>
                
                <div class="form-group">
                    <label for="image_filename">Имя файла изображения:</label>
                    <input type="text" id="image_filename" name="image_filename" 
                           placeholder="Например: php_logo.jpg">
                    <small style="color: #7f8c8d;">Файл должен находиться в папке img/</small>
                </div>
                
                <div class="btn-group">
                    <a href="index.php" class="btn btn-back">← Назад к списку</a>
                    <button type="submit" class="btn btn-submit">➕ Добавить термин</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>