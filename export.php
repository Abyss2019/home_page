<?php
require_once 'config.php';

// 检查是否是管理员（这里使用简单的密码验证，实际应用中应该使用更安全的方式）
session_start();
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

if (!$isAdmin) {
    // 如果不是管理员，检查密码
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_password'])) {
        // 这里设置一个简单的密码，实际应用中应该使用更安全的方式
        if ($_POST['admin_password'] === 'admin123') {
            $_SESSION['is_admin'] = true;
            $isAdmin = true;
        }
    }
    
    if (!$isAdmin) {
        // 显示登录表单
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>管理员登录</title>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                    min-height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin: 0;
                }
                .login-container {
                    background: white;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0,0,0,0.1);
                    width: 300px;
                }
                h2 {
                    text-align: center;
                    color: #2c3e50;
                    margin-bottom: 20px;
                }
                input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    margin: 10px 0;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    box-sizing: border-box;
                }
                button {
                    width: 100%;
                    padding: 10px;
                    background: #3498db;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                button:hover {
                    background: #2980b9;
                }
            </style>
        </head>
        <body>
            <div class="login-container">
                <h2>管理员登录</h2>
                <form method="POST">
                    <input type="password" name="admin_password" placeholder="请输入管理员密码" required>
                    <button type="submit">登录</button>
                </form>
            </div>
        </body>
        </html>';
        exit;
    }
}

// 如果是管理员，继续导出数据
if ($isAdmin) {
    // 设置响应头
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=users_' . date('Y-m-d') . '.csv');

    // 创建输出流
    $output = fopen('php://output', 'w');

    // 添加 UTF-8 BOM
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // 写入CSV头部
    fputcsv($output, ['用户名', '电子邮箱', '电话号码', '注册时间']);

    try {
        // 查询所有用户数据
        $stmt = $pdo->query("SELECT username, email, phone, created_at FROM users ORDER BY created_at DESC");
        
        // 写入数据
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['username'],
                $row['email'],
                $row['phone'],
                $row['created_at']
            ]);
        }
    } catch(PDOException $e) {
        echo "导出失败：" . $e->getMessage();
    }

    fclose($output);
}
?> 