<?php
// 设置返回格式为 JSON，允许跨域（如部署调试需要）
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// 获取 POST 数据（JSON 格式）
$data = json_decode(file_get_contents('php://input'), true);

// 简单字段验证
if (!isset($data['email']) || !isset($data['affiliation'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Missing email or affiliation"]);
    exit;
}

// 处理字段
$email = trim($data['email']);
$affiliation = trim($data['affiliation']);
$timestamp = date("Y-m-d H:i:s");

// 准备写入CSV
$file = __DIR__ . "/form_data.csv";
$line = [$timestamp, $email, $affiliation];

// 如果文件不存在，先写入表头
if (!file_exists($file)) {
    file_put_contents($file, "Timestamp,Email,Affiliation\n", FILE_APPEND);
}

// 写入数据
$fp = fopen($file, 'a');
fputcsv($fp, $line);
fclose($fp);

// 成功响应
echo json_encode(["status" => "success"]);

var_dump($file);

if (!isset($data['email']) || !isset($data['affiliation'])) {
    var_dump($data);
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Missing email or affiliation"]);
    exit;
}
?>
