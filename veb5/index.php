<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа №5 - XAMPP</title>
    <style>
        /* Основные стили */
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
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        
        h1 {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        h2 {
            color: #3498db;
            margin: 25px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        h3 {
            color: #2c3e50;
            margin: 20px 0 10px 0;
        }
        
        /* Кнопки */
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 5px;
        }
        
        .btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-add {
            background: #2ecc71;
        }
        
        .btn-add:hover {
            background: #27ae60;
        }
        
        .btn-back {
            background: #95a5a6;
        }
        
        .btn-back:hover {
            background: #7f8c8d;
        }
        
        /* Таблица */
        .table-container {
            overflow-x: auto;
            margin: 20px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        th {
            background: #3498db;
            color: white;
            font-weight: bold;
            padding: 15px;
            text-align: left;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        /* Изображения */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .image-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .image-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        
        .image-info {
            padding: 15px;
            text-align: center;
        }
        
        .image-title {
            font-weight: bold;
            color: #2c3e50;
            margin-top: 10px;
        }
        
        /* Форма */
        .form-container {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
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
        
        /* Сообщения */
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
        
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        /* Футер */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #7f8c8d;
        }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .gallery {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
            
            h1 {
                font-size: 1.8em;
            }
            
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Лабораторная работа №5</h1>
            <p style="color: #7f8c8d; margin-bottom: 20px;">Подключение к базе данных с помощью PHP (XAMPP)</p>
            <div>
                <a href="index.php" class="btn">Главная</a>
                <a href="add.php" class="btn btn-add">Добавить новый термин</a>
            </div>
        </div>
        
        <!-- Таблица терминов -->
        <h2>📚 Термины и их определения</h2>
        <div class="table-container">
            <?php
            // Подключаемся к базе данных
            include "db.php";
            
            // Выполняем запрос к таблице терминов
            $result = mysqli_query($mysql, "SELECT * FROM `terms` ORDER BY `id`");
            
            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr>
                        <th width="50">№</th>
                        <th>Термин</th>
                        <th>Определение</th>
                        <th width="150">Категория</th>
                      </tr>';
                
                $counter = 1;
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $counter . '</td>';
                    echo '<td><strong>' . htmlspecialchars($row['term']) . '</strong></td>';
                    echo '<td>' . htmlspecialchars($row['definition']) . '</td>';
                    echo '<td><span style="background: #e3f2fd; padding: 5px 10px; border-radius: 15px; font-size: 0.9em;">' 
                         . htmlspecialchars($row['category']) . '</span></td>';
                    echo '</tr>';
                    $counter++;
                }
                echo '</table>';
            } else {
                echo '<div class="message info">В базе данных пока нет терминов.</div>';
            }
            ?>
        </div>
        
        <!-- Галерея изображений -->
        <h2>🖼️ Изображения терминов</h2>
        <div class="gallery">
            <?php
            // Выполняем запрос к таблице изображений
            $result_images = mysqli_query($mysql, "SELECT * FROM `images` ORDER BY `id`");
            
            if (mysqli_num_rows($result_images) > 0) {
                while($image = mysqli_fetch_assoc($result_images)) {
                    echo '<div class="image-card">';
                    echo '<img src="img/' . htmlspecialchars($image['filename']) . '" 
                          title="' . htmlspecialchars($image['name']) . '" 
                          alt="' . htmlspecialchars($image['name']) . '"
                          onerror="this.src=\'img/default.jpg\'">';
                    echo '<div class="image-info">';
                    echo '<div class="image-title">' . htmlspecialchars($image['name']) . '</div>';
                    echo '</div></div>';
                }
            } else {
                echo '<div class="message info">В базе данных пока нет изображений.</div>';
            }
            
            // Закрываем соединение с БД
            mysqli_close($mysql);
            ?>
        </div>
        
        <div class="footer">
            <p>Лабораторная работа №5 | XAMPP + PHP + MySQL | © 2023</p>
        </div>
    </div>
</body>
</html>