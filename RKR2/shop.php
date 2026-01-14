<?php
require_once 'config.php';

// Получение параметров фильтрации
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин - Интернет-магазин электроники</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <div class="container">
            <h1>Каталог товаров</h1>
            
            <!-- Фильтры -->
            <div class="filters">
                <form method="GET" action="shop.php" class="filter-form">
                    <div class="filter-group">
                        <label>Категория:</label>
                        <select name="category">
                            <option value="0">Все категории</option>
                            <?php
                            $conn = getDBConnection();
                            $categories = $conn->query("SELECT * FROM categories");
                            while ($cat = $categories->fetch_assoc()) {
                                $selected = ($category_id == $cat['id']) ? 'selected' : '';
                                echo '<option value="' . $cat['id'] . '" ' . $selected . '>' . htmlspecialchars($cat['name']) . '</option>';
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Поиск:</label>
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Название товара...">
                    </div>
                    <button type="submit" class="btn">Применить</button>
                </form>
            </div>
            
            <!-- Таблица товаров -->
            <div class="view-toggle">
                <button onclick="toggleView('table')" class="view-btn active" id="table-view">Таблица</button>
                <button onclick="toggleView('grid')" class="view-btn" id="grid-view">Сетка</button>
            </div>
            
            <div id="products-table-view" class="products-view">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Цена</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = getDBConnection();
                        $query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
                        
                        if ($category_id > 0) {
                            $query .= " AND p.category_id = " . (int)$category_id;
                        }
                        
                        if (!empty($search)) {
                            $search_escaped = $conn->real_escape_string($search);
                            $query .= " AND p.name LIKE '%$search_escaped%'";
                        }
                        
                        $query .= " ORDER BY p.id";
                        
                        $result = $conn->query($query);
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td><img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" class="table-image"></td>';
                                echo '<td><strong>' . htmlspecialchars($row['name']) . '</strong><br><small>' . htmlspecialchars($row['category_name']) . '</small></td>';
                                echo '<td>' . htmlspecialchars(mb_substr($row['description'], 0, 100)) . '...</td>';
                                echo '<td class="price">' . number_format($row['price'], 2, '.', ' ') . ' ₽</td>';
                                echo '<td><a href="product.php?id=' . $row['id'] . '" class="btn btn-small">Подробнее</a></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center">Товары не найдены</td></tr>';
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div id="products-grid-view" class="products-view" style="display:none;">
                <div class="products-grid">
                    <?php
                    $conn = getDBConnection();
                    $result = $conn->query($query);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="product-card">';
                            echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                            echo '<p class="category">' . htmlspecialchars($row['category_name']) . '</p>';
                            echo '<p class="description">' . htmlspecialchars(mb_substr($row['description'], 0, 100)) . '...</p>';
                            echo '<p class="price">' . number_format($row['price'], 2, '.', ' ') . ' ₽</p>';
                            echo '<a href="product.php?id=' . $row['id'] . '" class="btn">Подробнее</a>';
                            echo '</div>';
                        }
                    }
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="js/shop.js"></script>
</body>
</html>

