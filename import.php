<?php

require_once('../../../wp-load.php');

echo "<h2>🔄 Import CATEGORY → CPT: cate_post</h2>";
echo "<style>body{font-family:Arial;padding:20px;} pre{background:#f5f5f5;padding:15px;border-radius:5px;overflow-x:auto;}</style>";
echo "<pre>";

// ===== FILE CSV =====
$csv_file = __DIR__ . '/import.csv';

if (!file_exists($csv_file)) {
    die("❌ Không tìm thấy file CSV: {$csv_file}");
}

$handle = fopen($csv_file, 'r');
$header = fgetcsv($handle); // đọc dòng header

if (!$header) {
    die("❌ CSV không có header");
}

// Tìm vị trí cột "merge"
$merge_index = array_search('merge', array_map('trim', $header));

if ($merge_index === false) {
    die("❌ Không tìm thấy cột 'merge' trong file CSV");
}

$count_created = 0;
$count_exist = 0;
$row_number = 1;

while (($row = fgetcsv($handle)) !== false) {
    $row_number++;

    $merge_value = trim($row[$merge_index]);

    if ($merge_value === '') {
        echo "⚠️ Row {$row_number}: cột merge trống → bỏ qua\n";
        continue;
    }

    // Tách theo dấu phẩy
    $categories = array_map('trim', explode(',', $merge_value));

    foreach ($categories as $cate) {
        if ($cate === '')
            continue;

        // Kiểm tra cate đã tồn tại chưa
        $existing = get_posts([
            'post_type' => 'cate_post',
            'title' => $cate,
            'posts_per_page' => 1,
            'post_status' => 'any'
        ]);

        if (!empty($existing)) {
            $count_exist++;
            echo "✔ Đã tồn tại: {$cate}\n";
            continue;
        }

        // Tạo post mới
        $post_id = wp_insert_post([
            'post_type' => 'cate_post',
            'post_title' => $cate,
            'post_status' => 'publish'
        ]);

        if ($post_id) {
            $count_created++;
            echo "➕ Tạo mới: {$cate}\n";
        } else {
            echo "❌ Lỗi tạo post: {$cate}\n";
        }
    }
}

echo "\n====================\n";
echo "TẠO MỚI: {$count_created}\n";
echo "ĐÃ TỒN TẠI: {$count_exist}\n";
echo "====================\n";
echo "</pre>";