<?php
$host = 'localhost';
$db   = 'vrocklab';
$user = 'vrockuser';
$pass = 'VRockLabHKU2025';

try {
    // 先只连到服务器（不指定数据库），以便创建数据库
    $dsn = "mysql:host={$host};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    
    // 如果数据库不存在，就创建它
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // 切换到该数据库
    $pdo->exec("USE `{$db}`");
    
    // 创建 users 表
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `email`    VARCHAR(100) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `phone`    VARCHAR(20) NOT NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    
    echo "数据库和表准备就绪。";
    
} catch (PDOException $e) {
    die("连接失败: " . $e->getMessage());
}
?>
