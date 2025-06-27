<?php
$file = __DIR__ . "/form_data.csv";

if (!file_exists($file)) {
    die("CSV file not found.");
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="form_data.csv"');
readfile($file);
exit;
