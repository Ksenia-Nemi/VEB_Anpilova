<?php
require_once 'config.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id == 0) {
    header('Location: shop.php');
    exit;
}

$conn = getDBConnection();
$stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$product) {
    header('Location: shop.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Интернет-магазин</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <div class="container">
            <div class="breadcrumbs">
                <a href="index.php">Главная</a> / 
                <a href="shop.php">Магазин</a> / 
                <span><?php echo htmlspecialchars($product['name']); ?></span>
            </div>
            
            <div class="product-detail">
                <div class="product-image-large">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                
                <div class="product-info">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="category-badge"><?php echo htmlspecialchars($product['category_name']); ?></p>
                    
                    <div class="price-large">
                        <?php echo number_format($product['price'], 2, '.', ' '); ?> ₽
                    </div>
                    
                    <div class="stock-info">
                        <?php if ($product['stock'] > 0): ?>
                            <span class="in-stock">✓ В наличии: <?php echo $product['stock']; ?> шт.</span>
                        <?php else: ?>
                            <span class="out-of-stock">✗ Нет в наличии</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-description">
                        <h3>Описание</h3>
                        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>
                    
                    <div class="product-specifications">
                        <h3>Характеристики</h3>
                        <div class="specs-list">
                            <?php
                            $specs = explode(',', $product['specifications']);
                            echo '<ul>';
                            foreach ($specs as $spec) {
                                $spec = trim($spec);
                                if (!empty($spec)) {
                                    echo '<li>' . htmlspecialchars($spec) . '</li>';
                                }
                            }
                            echo '</ul>';
                            ?>
                        </div>
                    </div>
                    
                    <?php if (isLoggedIn()): ?>
                        <div class="product-actions">
                            <button onclick="addToWishlist(<?php echo $product['id']; ?>)" class="btn btn-primary">
                                Добавить в список покупок
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="product-actions">
                            <p class="login-prompt">Для добавления в список покупок необходимо <a href="login.php">войти</a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="js/wishlist.js"></script>
</body>
</html>

