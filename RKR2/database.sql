-- База данных для интернет-магазина
-- Создание базы данных
CREATE DATABASE IF NOT EXISTS shop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE shop_db;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица категорий товаров
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица товаров
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    specifications TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица списка покупок (корзина)
CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица обратной связи
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Вставка тестовых данных

-- Категории
INSERT INTO categories (name, description) VALUES
('Смартфоны', 'Современные смартфоны различных производителей'),
('Ноутбуки', 'Ноутбуки для работы и игр'),
('Планшеты', 'Планшеты для работы и развлечений');

-- Товары
INSERT INTO products (category_id, name, description, price, image, stock, specifications) VALUES
(1, 'iPhone 15 Pro', 'Новейший смартфон от Apple с процессором A17 Pro и камерой 48 МП', 99999.00, 'images/iphone15.jpg', 15, 'Процессор: A17 Pro, Экран: 6.1", Камера: 48 МП, Память: 256 ГБ, Батарея: 3274 мАч'),
(1, 'Samsung Galaxy S24', 'Флагманский смартфон Samsung с искусственным интеллектом', 89999.00, 'images/galaxy_s24.jpg', 20, 'Процессор: Snapdragon 8 Gen 3, Экран: 6.2", Камера: 50 МП, Память: 256 ГБ, Батарея: 4000 мАч'),
(1, 'Xiaomi 14', 'Мощный смартфон с отличным соотношением цена/качество', 49999.00, 'images/xiaomi14.jpg', 30, 'Процессор: Snapdragon 8 Gen 3, Экран: 6.36", Камера: 50 МП, Память: 256 ГБ, Батарея: 4610 мАч'),
(2, 'MacBook Pro 16"', 'Профессиональный ноутбук для творческих задач', 249999.00, 'images/macbook_pro.jpg', 8, 'Процессор: M3 Pro, Экран: 16.2", Память: 512 ГБ SSD, ОЗУ: 18 ГБ, Батарея: до 22 часов'),
(2, 'ASUS ROG Strix G16', 'Игровой ноутбук с мощной видеокартой', 149999.00, 'images/asus_rog.jpg', 12, 'Процессор: Intel Core i7-13700H, Видеокарта: RTX 4060, Экран: 16", ОЗУ: 16 ГБ, Память: 512 ГБ SSD'),
(2, 'Lenovo ThinkPad X1', 'Бизнес-ноутбук премиум класса', 129999.00, 'images/thinkpad.jpg', 10, 'Процессор: Intel Core i7-1355U, Экран: 14", ОЗУ: 16 ГБ, Память: 512 ГБ SSD, Вес: 1.12 кг'),
(3, 'iPad Pro 12.9"', 'Профессиональный планшет для творчества', 119999.00, 'images/ipad_pro.jpg', 15, 'Процессор: M2, Экран: 12.9", Память: 256 ГБ, Поддержка Apple Pencil, Батарея: до 10 часов'),
(3, 'Samsung Galaxy Tab S9', 'Планшет премиум класса с S Pen', 89999.00, 'images/galaxy_tab.jpg', 18, 'Процессор: Snapdragon 8 Gen 2, Экран: 11", Память: 256 ГБ, S Pen в комплекте, Батарея: 8400 мАч');

-- Тестовый пользователь (пароль: admin123)
INSERT INTO users (username, email, password) VALUES
('admin', 'admin@shop.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

