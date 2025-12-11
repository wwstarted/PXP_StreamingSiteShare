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
    // 1. TÌM HOẶC TẠO POST (mặc định)
    // ==========================

    $existing = get_page_by_title($brand, OBJECT, 'post');

    if ($existing) {
        $post_id = $existing->ID;
        echo "UPDATE post: $brand (ID $post_id)\n";
    } else {
        $post_id = wp_insert_post([
            'post_title' => $brand,
            'post_type' => 'post',
            'post_status' => 'publish'
        ]);

        echo "ADD post: $brand (ID $post_id)\n";
    }

    // ==========================
    // 2. UPDATE META post_link
    // ==========================
    update_post_meta($post_id, 'post_link', $website);


    // ==========================
    // 3. XỬ LÝ DANH SÁCH CATEGORY
    // ==========================
    $cate_titles = array_map('trim', explode(',', $merge));
    $term_ids = [];

    foreach ($cate_titles as $cate_name) {
        if ($cate_name == '')
            continue;

        // Tìm category trong taxonomy
        $term = get_term_by('name', $cate_name, 'category');

        if ($term) {
            $term_ids[] = $term->term_id;
            echo "  ✔ Category tồn tại: $cate_name (ID: {$term->term_id})\n";
        } else {
            // Tạo category mới tự động
            $new_term = wp_insert_term($cate_name, 'category');

            if (!is_wp_error($new_term)) {
                $term_ids[] = $new_term['term_id'];
                echo "  ➕ Tạo category mới: $cate_name (ID: {$new_term['term_id']})\n";
            } else {
                echo "  ❌ Lỗi tạo category: $cate_name - " . $new_term->get_error_message() . "\n";
            }
        }
    }

    // Gán categories cho post (MERGE với categories cũ)
    if (!empty($term_ids)) {
        wp_set_object_terms($post_id, $term_ids, 'category', true); // true = append/merge
        echo "→ MERGE categories: [" . implode(',', $term_ids) . "]\n\n";
    }
}

echo "</pre>";
echo "DONE!";