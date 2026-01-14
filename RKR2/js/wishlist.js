// Функция добавления товара в список покупок
function addToWishlist(productId) {
    // Проверяем, авторизован ли пользователь
    fetch('api/add_to_wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Товар добавлен в список покупок!');
        } else {
            alert(data.message || 'Ошибка при добавлении товара');
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при добавлении товара');
    });
}

