<?php
// Устанавливаем московский часовой пояс
date_default_timezone_set('Europe/Moscow');

// Получаем текущую секунду для выбора фотографии
$currentSecond = (int)date('s');
$isEvenSecond = ($currentSecond % 2 == 0);
$photoFile1 = $isEvenSecond ? 'photo1.jpg' : 'photo2.jpg';
$photoFile2 = $isEvenSecond ? 'photo2.jpg' : 'photo1.jpg';
$photoAlt1 = $isEvenSecond ? 'Дельфин крупным планом' : 'Три дельфина в прыжке';
$photoAlt2 = $isEvenSecond ? 'Три дельфина в прыжке' : 'Дельфин крупным планом';

// Данные для меню
$menuItems = [
    ['page' => 'index.php', 'text' => 'Главная'],
    ['page' => 'about.php', 'text' => 'О дельфинах'],
    ['page' => 'gallery.php', 'text' => 'Фотогалерея']
];

// Данные для списка интересных фактов
$communicationFacts = [
    'Дельфины общаются с помощью свистов, щелчков и других звуков',
    'Каждый дельфин имеет уникальный свист-сигнатуру, как имя',
    'Они могут имитировать звуки других животных и даже человеческую речь',
    'Дельфины используют эхолокацию для создания звуковой картины окружающего мира',
    'Они способны передавать информацию о местоположении, размере и форме объектов',
    'Дельфины могут общаться на расстоянии до нескольких километров',
    'Они используют различные позы и движения тела для коммуникации',
    'Дельфины могут обучать друг друга новым навыкам и поведению'
];

$currentPage = 'gallery.php';
$pageTitle = "Анпилова Ксения Сергеевна, группа 241-361, Лабораторная работа №3";
$footerTime = date('H:i:s');
$moscowDate = date('d.m.Y');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- УБРАНО автоматическое обновление -->
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
        .photo-container img { 
            max-width: 45%; 
            height: auto; 
            max-height: 400px; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            margin: 10px; 
            transition: transform 0.3s ease;
        }
        .photo-container img:hover {
            transform: scale(1.05);
        }
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
        .photo-explanation {
            text-align: center;
            color: #7f8c8d;
            font-size: 0.9em;
            margin-top: 5px;
            margin-bottom: 20px;
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
            <h1>Фотогалерея дельфинов</h1>

            <h2>Красота морских млекопитающих</h2>
            <p>Дельфины - одни из самых фотогеничных обитателей океана. Их грациозные движения, игривое поведение и выразительные лица делают их популярными объектами для фотографии. На фотографиях можно увидеть различные моменты из жизни дельфинов: прыжки из воды, плавание, общение с сородичами и взаимодействие с людьми.</p>

            <p>Фотографии дельфинов помогают нам лучше понять этих удивительных животных и их поведение. Они демонстрируют красоту и разнообразие морской жизни, а также важность сохранения океанических экосистем. Многие фотографы посвящают годы своей жизни съемке дельфинов, чтобы запечатлеть уникальные моменты их жизни.</p>

            <h2>Интересные факты о коммуникации дельфинов</h2>
            <ul>
                <?php foreach ($communicationFacts as $fact): ?>
                    <li><?php echo $fact; ?></li>
                <?php endforeach; ?>
            </ul>

            <h2>Фотографии дельфинов</h2>
            <div class="photo-explanation">
                Порядок фотографий зависит от четности текущей секунды
            </div>
            <div class="photo-container">
                <img src="<?php echo $photoFile1; ?>" alt="<?php echo $photoAlt1; ?>">
                <img src="<?php echo $photoFile2; ?>" alt="<?php echo $photoAlt2; ?>">
            </div>

            <div class="time-info">
                Текущая секунда (МСК): <strong><?php echo $currentSecond; ?></strong> 
                (<strong><?php echo $isEvenSecond ? 'четная - порядок фото: 1, 2' : 'нечетная - порядок фото: 2, 1'; ?></strong>)
            </div>

            <div class="refresh-info">
                <p><strong>Для изменения порядка фотографий:</strong></p>
                <p>Нажмите F5 или Ctrl+R, либо кликните по кнопке ниже</p>
                <a href="javascript:location.reload()" class="refresh-button">Обновить страницу</a>
                <p style="margin-top: 10px; font-size: 0.9em; color: #7f8c8d;">
                    При обновлении изменится секунда и порядок фотографий
                </p>
            </div>
        </div>
    </main>
    
    <footer>
        <div>Сформировано <?php echo $moscowDate; ?> в <?php echo $footerTime; ?> <span class="msk-badge">MSK</span></div>
        <div class="footer-time">
            Время генерации страницы: <?php echo $footerTime; ?>
        </div>
    </footer>
</body>
</html>