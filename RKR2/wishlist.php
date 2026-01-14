<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Обработка удаления из списка покупок
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    $conn = getDBConnection();
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: wishlist.php');
    exit;
}

// Получение списка покупок
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT p.*, w.added_at FROM products p INNER JOIN wishlist w ON p.id = w.product_id WHERE w.user_id = ? ORDER BY w.added_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$wishlist_items = [];
while ($row = $result->fetch_assoc()) {
    $wishlist_items[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список покупок - Интернет-магазин</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <div class="container">
            <h1>Мой список покупок</h1>
            
            <?php if (empty($wishlist_items)): ?>
                <div class="empty-wishlist">
                    <p>Ваш список покупок пуст.</p>
                    <a href="shop.php" class="btn btn-primary">Перейти в магазин</a>
                </div>
            <?php else: ?>
                <div class="wishlist-grid">
                    <?php foreach ($wishlist_items as $item): ?>
                        <div class="wishlist-item">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="price"><?php echo number_format($item['price'], 2, '.', ' '); ?> ₽</p>
                            <div class="wishlist-actions">
                                <a href="product.php?id=<?php echo $item['id']; ?>" class="btn btn-small">Подробнее</a>
                                <a href="wishlist.php?remove=<?php echo $item['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Удалить из списка покупок?')">Удалить</a>
                            </div>
                            <small>Добавлено: <?php echo date('d.m.Y', strtotime($item['added_at'])); ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>

