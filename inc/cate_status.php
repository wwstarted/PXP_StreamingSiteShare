<?php
/**
 * Thêm Meta Box Visibility cho CPT cate_post
 * Đặt code này vào functions.php
 */

// QUAN TRỌNG: Register meta field để expose ra REST API
add_action('init', 'register_cate_post_visibility_meta');
function register_cate_post_visibility_meta()
{
    register_post_meta('cate_post', '_cate_post_visible', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,  // Expose ra REST API
        'default' => '1',         // Mặc định là hiển thị
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
}

// Thêm Meta Box ở sidebar bên phải
add_action('add_meta_boxes', 'add_cate_post_visibility_meta_box');
function add_cate_post_visibility_meta_box()
{
    add_meta_box(
        'cate_post_visibility',           // ID
        'Hiển thị',                       // Title
        'render_cate_post_visibility_box', // Callback
        'cate_post',                      // Post type
        'side',                           // Context: 'side' để hiển thị bên phải
        'high'                            // Priority: 'high' để hiển thị ở trên
    );
}

// Render nội dung Meta Box
function render_cate_post_visibility_box($post)
{
    // Lấy giá trị hiện tại
    $is_visible = get_post_meta($post->ID, '_cate_post_visible', true);

    // Nếu chưa có giá trị, mặc định là checked (hiển thị)
    if ($is_visible === '') {
        $is_visible = '1';
    }

    // Nonce field để bảo mật
    wp_nonce_field('cate_post_visibility_nonce', 'cate_post_visibility_nonce_field');
    ?>

    <div style="padding: 10px 0;">
        <label style="display: flex; align-items: center; cursor: pointer;">
            <input type="checkbox" name="cate_post_visible" value="1" <?php checked($is_visible, '1'); ?>
                style="margin-right: 8px;" />
            <span>Show in homepage</span>
        </label>
        <p class="description" style="margin-top: 8px; color: #666;">
            Tick để hiển thị category
        </p>
    </div>

    <?php
}

// Lưu giá trị khi save post
add_action('save_post_cate_post', 'save_cate_post_visibility_meta', 10, 2);
function save_cate_post_visibility_meta($post_id, $post)
{
    // Kiểm tra nonce
    if (
        !isset($_POST['cate_post_visibility_nonce_field']) ||
        !wp_verify_nonce($_POST['cate_post_visibility_nonce_field'], 'cate_post_visibility_nonce')
    ) {
        return;
    }

    // Kiểm tra autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Kiểm tra quyền
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Lưu giá trị
    $is_visible = isset($_POST['cate_post_visible']) ? '1' : '0';
    update_post_meta($post_id, '_cate_post_visible', $is_visible);
}

// Thêm column vào admin list để dễ quản lý
add_filter('manage_cate_post_posts_columns', 'add_cate_post_visibility_column');
function add_cate_post_visibility_column($columns)
{
    $columns['visibility'] = 'Hiển thị';
    return $columns;
}

add_action('manage_cate_post_posts_custom_column', 'show_cate_post_visibility_column', 10, 2);
function show_cate_post_visibility_column($column, $post_id)
{
    if ($column === 'visibility') {
        $is_visible = get_post_meta($post_id, '_cate_post_visible', true);
        if ($is_visible === '1') {
            echo '<span style="color: #46b450;">✓ Hiển thị</span>';
        } else {
            echo '<span style="color: #dc3232;">✗ Ẩn</span>';
        }
    }
}
?>