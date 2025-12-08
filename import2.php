<?php
// Load WordPress
require_once('../../../wp-load.php');

$file = __DIR__ . '/import.csv';

if (!file_exists($file)) {
    die("Không tìm thấy file CSV");
}

$rows = array_map('str_getcsv', file($file));
$header = array_map('trim', $rows[0]);
$data = [];

foreach ($rows as $index => $row) {
    if ($index == 0)
        continue;
    $rowData = array_combine($header, $row);
    if (!$rowData)
        continue;
    $data[] = $rowData;
}

echo "<pre>";

foreach ($data as $row) {

    $brand = trim($row['brand']);
    $website = trim($row['website']);
    $merge = trim($row['merge']);

    if ($brand == '')
        continue;

    // ==========================
    // 1. TÌM HOẶC TẠO post_item
    // ==========================

    $existing = get_page_by_title($brand, OBJECT, 'post_item');

    if ($existing) {
        $post_id = $existing->ID;
        echo "UPDATE post_item: $brand (ID $post_id)\n";
    } else {
        $post_id = wp_insert_post([
            'post_title' => $brand,
            'post_type' => 'post_item',
            'post_status' => 'publish'
        ]);

        echo "ADD post_item: $brand (ID $post_id)\n";
    }

    // ==========================
    // 2. UPDATE META post_link
    // ==========================
    update_post_meta($post_id, 'post_link', $website);


    // ==========================
    // 3. XỬ LÝ DANH SÁCH CATEGORY
    // ==========================
    $cate_titles = array_map('trim', explode(',', $merge));
    $cate_ids = [];

    foreach ($cate_titles as $cate_name) {
        if ($cate_name == '')
            continue;

        // tìm cate_post (đã import trước đó)
        $cate_exist = get_page_by_title($cate_name, OBJECT, 'cate_post');

        if ($cate_exist) {
            $cate_ids[] = $cate_exist->ID;
        } else {
            echo "⚠ Category không tồn tại: $cate_name — bỏ qua\n";
        }
    }

    // Ghi đè id_cate_post
    update_post_meta($post_id, 'id_cate_post', $cate_ids);

    echo "→ Set id_cate_post = [" . implode(',', $cate_ids) . "]\n\n";
}

echo "</pre>";
echo "DONE!";