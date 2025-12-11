<?php
// Load WordPress
require_once('../../../wp-load.php');

$file = __DIR__ . '/import2.csv';

if (!file_exists($file)) {
    die("Không tìm thấy file CSV");
}

$rows = array_map('str_getcsv', file($file));

echo "<pre>";
echo "<h2>🔍 DEBUG: Kiểm tra cấu trúc CSV</h2>";
echo "==========================================\n\n";

// DEBUG: In ra row đầu tiên (data, không phải header)
if (isset($rows[1])) {
    echo "📊 ROW 1 (Data đầu tiên):\n\n";
    foreach ($rows[1] as $index => $value) {
        $preview = strlen($value) > 100 ? substr($value, 0, 100) . '...' : $value;
        echo "Index [$index]: $preview\n\n";
    }
}

echo "==========================================\n";
echo "Bạn kiểm tra xem:\n";
echo "- Index nào chứa 'brand' (tên như 9Anime)?\n";
echo "- Index nào chứa 'website' (https://9animelv.to/)?\n";
echo "- Index nào chứa 'logo' (URL Google favicons dài)?\n";
echo "- Index nào chứa 'cate' (Free Streaming Apps...)?\n";
echo "</pre>";