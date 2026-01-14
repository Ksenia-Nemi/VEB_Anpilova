<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo.png" alt="Логотип" class="logo-img">
                    <span class="logo-text">TechShop</span>
                </a>
            </div>
            
            <nav class="navbar">
                <ul class="nav-menu">
                    <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Главная</a></li>
                    <li><a href="shop.php" class="<?php echo $current_page == 'shop.php' ? 'active' : ''; ?>">Магазин</a></li>
                    <li><a href="about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">О нас</a></li>
                </ul>
            </nav>
            
            <div class="header-actions">
                <?php if (isLoggedIn()): ?>
                    <?php $user = getCurrentUser(); ?>
                    <div class="user-menu">
                        <span class="username"><?php echo htmlspecialchars($user['username']); ?></span>
                        <div class="user-dropdown">
                            <a href="wishlist.php">Список покупок</a>
                            <a href="feedback.php">Обратная связь</a>
                            <a href="logout.php">Выход</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-small">Войти</a>
                    <a href="register.php" class="btn btn-small btn-outline">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

