-- Создание базы данных tech_shop
CREATE DATABASE IF NOT EXISTS `tech_shop` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `tech_shop`;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `pass_hash` VARCHAR(255) NOT NULL,
    `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица игр
CREATE TABLE IF NOT EXISTS `games` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `price` INT UNSIGNED NOT NULL DEFAULT 0,
    `short_desc` TEXT NOT NULL,
    `long_desc` TEXT NOT NULL,
    `cover` VARCHAR(255) NOT NULL DEFAULT '',
    `stock` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `idx_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица атрибутов игр
CREATE TABLE IF NOT EXISTS `game_attrs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `game_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `value` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_game_id` (`game_id`),
    INDEX `idx_name` (`name`),
    FOREIGN KEY (`game_id`) REFERENCES `games`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица заказов
CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `total` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_created_at` (`created_at`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица элементов заказа
CREATE TABLE IF NOT EXISTS `order_items` (
    `order_id` INT UNSIGNED NOT NULL,
    `game_id` INT UNSIGNED NOT NULL,
    `qty` INT UNSIGNED NOT NULL DEFAULT 1,
    `price` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`order_id`, `game_id`),
    INDEX `idx_game_id` (`game_id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`game_id`) REFERENCES `games`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица списка покупок пользователя (shoplist)
CREATE TABLE IF NOT EXISTS `shoplist` (
    `user_id` INT UNSIGNED NOT NULL,
    `game_id` INT UNSIGNED NOT NULL,
    `qty` INT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (`user_id`, `game_id`),
    INDEX `idx_game_id` (`game_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`game_id`) REFERENCES `games`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

