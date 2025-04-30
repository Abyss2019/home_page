<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    
    // 数据验证
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "用户名不能为空";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "请输入有效的电子邮箱";
    }
    
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "密码长度至少为6个字符";
    }
    
    if (empty($phone) || !preg_match("/^1[3-9]\d{9}$/", $phone)) {
        $errors[] = "请输入有效的手机号码";
    }
    
    if (empty($errors)) {
        try {
            // 检查用户名是否已存在
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "用户名已存在";
            } else {
                // 密码加密
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // 插入数据
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, phone, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$username, $email, $hashed_password, $phone]);
                
                echo "<script>alert('注册成功！'); window.location.href='register.php';</script>";
                exit();
            }
        } catch(PDOException $e) {
            $errors[] = "注册失败：" . $e->getMessage();
        }
    }
    
    if (!empty($errors)) {
        echo "<script>alert('" . implode("\\n", $errors) . "'); window.location.href='register.php';</script>";
    }
}
?> 