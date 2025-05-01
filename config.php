<?php
$host = 'localhost';
$db   = 'vrocklab';
$user = 'vrockuser';
$pass = 'VRockLabHKU2025';

try {
    // 首先尝试连接MySQL服务器
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 检查数据库是否存在，如果不存在则创建
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    
    // 选择数据库
    $pdo->exec("USE `$dbname`");
    
    // 创建用户表（如果不存在）
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        created_at DATETIME NOT NULL
    )");
    
} catch(PDOException $e) {
    die("连接失败: " . $e->getMessage());
}
?> 