<?php
// Устанавливаем московский часовой пояс
date_default_timezone_set('Europe/Moscow');

// Получаем текущее время
$currentSecond = (int)date('s');
$currentTime = date('H:i:s');
$currentDate = date('d.m.Y');

// Определяем какое фото показывать
$isEvenSecond = ($currentSecond % 2 == 0);
$photoFile1 = $isEvenSecond ? 'photo1.jpg' : 'photo2.jpg';
$photoAlt1 = $isEvenSecond ? 'Дельфин крупным планом' : 'Три дельфина в прыжке';

// Данные для меню
$menuItems = [
    ['page' => 'index.php', 'text' => 'Главная'],
    ['page' => 'about.php', 'text' => 'О дельфинах'],
    ['page' => 'gallery.php', 'text' => 'Фотогалерея']
];

$currentPage = 'index.php';
$pageTitle = "Анпилова Ксения Сергеевна, группа 241-361, Лабораторная работа №3";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f4f4f4; display: flex; flex-direction: column; min-height: 100vh; }
        header { position: fixed; top: 0; left: 0; right: 0; height: 80px; background: #2c3e50; color: white; z-index: 1000; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        nav { height: 100%; display: flex; align-items: center; justify-content: center; }
        nav ul { list-style: none; display: flex; gap: 30px; }
        nav ul li a { color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; transition: background 0.3s; }
        nav ul li a:hover { background: #34495e; }
        nav ul li a.selected_menu { background: #3498db; font-weight: bold; }
        main { margin-top: 80px; flex: 1; padding: 30px 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; margin-bottom: 20px; font-size: 2.5em; }
        h2 { color: #34495e; margin-top: 30px; margin-bottom: 15px; font-size: 1.8em; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        p { margin-bottom: 15px; text-align: justify; font-size: 16px; }
        ul, ol { margin-left: 30px; margin-bottom: 20px; }
        li { margin-bottom: 10px; padding: 8px; background: #f8f9fa; border-left: 4px solid #3498db; border-radius: 3px; }
        .photo-container { text-align: center; margin: 30px 0; }
        .photo-container img { max-width: 100%; height: auto; max-height: 400px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin: 10px; }
        .time-info { text-align: center; color: #7f8c8d; font-style: italic; margin-top: 10px; padding: 10px; background: #ecf0f1; border-radius: 5px; }
        footer { height: 90px; background: #2c3e50; color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; margin-top: auto; padding: 15px; text-align: center; }
        .footer-time { margin-top: 8px; font-size: 0.9em; color: #bdc3c7; }
        .msk-badge { background: #e74c3c; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.7em; margin-left: 5px; vertical-align: middle; }
        .refresh-info { 
            text-align: center; 
            color: #2c3e50; 
            font-size: 1em; 
            margin-top: 15px; 
            padding: 15px;
            background: #e8f4fc;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        .refresh-button {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            transition: background 0.3s;
        }
        .refresh-button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <?php foreach ($menuItems as $menuItem): ?>
                    <?php $menuClass = ($currentPage == $menuItem['page']) ? 'selected_menu' : ''; ?>
                    <li>
                        <a href="<?php echo $menuItem['page']; ?>" class="<?php echo $menuClass; ?>">
                            <?php echo $menuItem['text']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="container">
            <h1>Мир дельфинов</h1>

            <h2>Введение</h2>
            <p>Дельфины - это удивительные морские млекопитающие, которые на протяжении веков привлекают внимание людей своей красотой, интеллектом и дружелюбным характером.</p>

            <h2>Фотографии дельфинов</h2>
            <div class="photo-container">
                <img src="<?php echo $photoFile1; ?>" alt="<?php echo $photoAlt1; ?>">
            </div>

            <div class="time-info">
                Текущая секунда (МСК): <strong><?php echo $currentSecond; ?></strong> 
                (<strong><?php echo $isEvenSecond ? 'четная - показывается фото 1' : 'нечетная - показывается фото 2'; ?></strong>)
            </div>

        
        </div>
    </main>
    
    <footer>
        <div>Сформировано <?php echo $currentDate; ?> в <?php echo $currentTime; ?> <span class="msk-badge">MSK</span></div>
        <div class="footer-time">
            Время генерации страницы: <?php echo $currentTime; ?>
        </div>
    </footer>
</body>
</html>