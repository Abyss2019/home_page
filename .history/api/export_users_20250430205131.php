<?php
require_once 'db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['ID', 'Name', 'Email', 'Created At']);

$stmt = $pdo->query("SELECT id, name, email, created_at FROM users");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}
fclose($output);
exit;
