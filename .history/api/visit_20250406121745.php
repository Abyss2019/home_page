<?php
// 文件路径（可自定义保存路径）
$counterFile = __DIR__ . '/counter.txt';

// 如果文件不存在，先创建
if (!file_exists($counterFile)) {
  file_put_contents($counterFile, "0");
}

// 读取当前访问量
$count = (int)file_get_contents($counterFile);

// +1
$count++;

// 写入更新后值
file_put_contents($counterFile, $count);

// 设置响应头为 JSON
header('Content-Type: application/json');
echo json_encode(['visits' => $count]);
?>
