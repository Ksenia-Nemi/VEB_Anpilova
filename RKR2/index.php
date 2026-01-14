<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная - Интернет-магазин электроники</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <!-- Слайд-шоу -->
        <section class="slideshow-container">
            <div class="slide fade">
                <img src="images/slide1.jpg" alt="Слайд 1" style="width:100%">
                <div class="slide-text">Новейшие смартфоны 2024</div>
            </div>
            <div class="slide fade">
                <img src="images/slide2.jpg" alt="Слайд 2" style="width:100%">
                <div class="slide-text">Мощные ноутбуки для работы и игр</div>
            </div>
            <div class="slide fade">
                <img src="images/slide3.jpg" alt="Слайд 3" style="width:100%">
                <div class="slide-text">Планшеты нового поколения</div>
            </div>
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
        </section>
        
        <!-- О магазине -->
        <section class="about-section">
            <div class="container">
                <h2>О нашем магазине</h2>
                <div class="about-content">
                    <div class="about-text">
                        <p>Добро пожаловать в наш интернет-магазин электроники! Мы предлагаем широкий ассортимент современных гаджетов и устройств от ведущих производителей.</p>
                        <p>Наша миссия - предоставить вам качественную технику по доступным ценам с гарантией и профессиональной поддержкой.</p>
                        <h3>Почему выбирают нас:</h3>
                        <ul>
                            <li>✅ Официальная гарантия на всю продукцию</li>
                            <li>✅ Быстрая доставка по всей стране</li>
                            <li>✅ Профессиональная консультация</li>
                            <li>✅ Выгодные цены и акции</li>
                            <li>✅ Удобная система оплаты</li>
                        </ul>
                    </div>
                    <div class="about-image">
                        <img src="images/store.jpg" alt="Наш магазин">
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Обзор продукции -->
        <section class="products-preview">
            <div class="container">
                <h2>Популярные товары</h2>
                <div class="products-grid">
                    <?php
                    $conn = getDBConnection();
                    $result = $conn->query("SELECT * FROM products ORDER BY id LIMIT 6");
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="product-card">';
                            echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                            echo '<p class="price">' . number_format($row['price'], 2, '.', ' ') . ' ₽</p>';
                            echo '<a href="product.php?id=' . $row['id'] . '" class="btn">Подробнее</a>';
                            echo '</div>';
                        }
                    }
                    $conn->close();
                    ?>
                </div>
                <div class="text-center">
                    <a href="shop.php" class="btn btn-primary">Перейти в магазин</a>
                </div>
            </div>
        </section>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="js/slideshow.js"></script>
</body>
</html>

