<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Необходимо войти в систему']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Неверный метод запроса']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$product_id = isset($data['product_id']) ? (int)$data['product_id'] : 0;

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Неверный ID товара']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Проверяем, существует ли товар
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    echo json_encode(['success' => false, 'message' => 'Товар не найден']);
    exit;
}

// Проверяем, не добавлен ли уже товар в список покупок
$stmt = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt->close();
    $conn->close();
    echo json_encode(['success' => false, 'message' => 'Товар уже в списке покупок']);
    exit;
}

// Добавляем товар в список покупок
$stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Товар успешно добавлен']);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при добавлении товара']);
}

$stmt->close();
$conn->close();
?>

