<?php
// Load WordPress
require_once('../../../wp-load.php');

$file = __DIR__ . '/import2.csv';

if (!file_exists($file)) {
    die("Không tìm thấy file CSV");
}

$rows = array_map('str_getcsv', file($file));

echo "<pre>";
echo "<h2>🔄 Import Data to WordPress Post</h2>";
echo "==========================================\n\n";

$count_created = 0;
$count_updated = 0;

// URL ảnh background mặc định
$default_bgr_image = 'https://images.freecreatives.com/wp-content/uploads/2016/04/Website-Backgrounds-For-Desktop.jpg';

foreach ($rows as $index => $row) {
    // Bỏ qua header row
    if ($index == 0) {
        continue;
    }

    // Lấy dữ liệu theo INDEX cột
    $brand = isset($row[1]) ? trim($row[1]) : '';      // Index 1
    $website = isset($row[2]) ? trim($row[2]) : '';    // Index 2
    $logo = isset($row[5]) ? trim($row[5]) : '';       // Index 5
    $cate = isset($row[6]) ? trim($row[6]) : '';       // Index 6

    if ($brand == '') {
        echo "⚠️ Row $index: brand trống → bỏ qua\n\n";
        continue;
    }

    // ==========================
    // 1. TÌM HOẶC TẠO POST
    // ==========================

    $existing = get_page_by_title($brand, OBJECT, 'post');

    if ($existing) {
        $post_id = $existing->ID;
        $count_updated++;
        echo "🔄 UPDATE post: $brand (ID $post_id)\n";
    } else {
        $post_id = wp_insert_post([
            'post_title' => $brand,
            'post_type' => 'post',
            'post_status' => 'publish'
        ]);

        if (is_wp_error($post_id)) {
            echo "❌ Lỗi tạo post: $brand - " . $post_id->get_error_message() . "\n\n";
            continue;
        }

        $count_created++;
        echo "➕ ADD post: $brand (ID $post_id)\n";
    }

    // ==========================
    // 2. UPDATE CUSTOM FIELDS
    // ==========================

    // Update post_link
    if ($website != '') {
        update_post_meta($post_id, 'post_link', $website);
        echo "  ✅ post_link = $website\n";
    }

    // Update logo
    if ($logo != '') {
        update_post_meta($post_id, 'logo', $logo);
        echo "  ✅ logo = " . substr($logo, 0, 60) . "...\n";
    }

    // Update bgr_image (ảnh mặc định)
    update_post_meta($post_id, 'bgr_image', $default_bgr_image);
    echo "  ✅ bgr_image = [default background]\n";

    // Update popularity (random 0-100)
    $popularity = rand(0, 100);
    update_post_meta($post_id, 'popularity', $popularity);
    echo "  ✅ popularity = {$popularity}%\n";

    // ==========================
    // 3. XỬ LÝ CATEGORIES
    // ==========================

    if ($cate != '') {
        // Tách theo dấu phẩy
        $cate_names = array_map('trim', explode(',', $cate));
        $term_ids = [];

        foreach ($cate_names as $cate_name) {
            if ($cate_name == '')
                continue;

            // Tìm category
            $term = get_term_by('name', $cate_name, 'category');

            if ($term) {
                $term_ids[] = $term->term_id;
                echo "  ✔ Category: $cate_name (ID: {$term->term_id})\n";
            } else {
                // Tạo category mới
                $new_term = wp_insert_term($cate_name, 'category');

                if (!is_wp_error($new_term)) {
                    $term_ids[] = $new_term['term_id'];
                    echo "  ➕ Tạo category: $cate_name (ID: {$new_term['term_id']})\n";
                } else {
                    echo "  ❌ Lỗi tạo category: $cate_name\n";
                }
            }
        }

        // MERGE categories (true = append, không xóa categories cũ)
        if (!empty($term_ids)) {
            wp_set_object_terms($post_id, $term_ids, 'category', true);
            echo "  → MERGE " . count($term_ids) . " categories\n";
        }
    }

    echo "\n";
}

echo "==========================================\n";
echo "✅ TẠO MỚI: $count_created posts\n";
echo "🔄 CẬP NHẬT: $count_updated posts\n";
echo "==========================================\n";
echo "</pre>";
echo "<h3>DONE! ✨</h3>";