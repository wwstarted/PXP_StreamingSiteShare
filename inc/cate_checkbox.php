<?php
/**
 * Multi-select Categories cho CPT post_item
 * Thêm code này vào functions.php
 */

// QUAN TRỌNG: Register meta field để expose ra REST API
add_action('init', 'register_post_item_cate_meta');
function register_post_item_cate_meta()
{
    register_post_meta('post_item', 'id_cate_post', array(
        'type' => 'array',
        'single' => true,
        'show_in_rest' => array(
            'schema' => array(
                'type' => 'array',
                'items' => array(
                    'type' => 'integer'
                )
            )
        ),
        'default' => array(),
        'sanitize_callback' => function ($value) {
            if (!is_array($value)) {
                return array();
            }
            return array_map('intval', $value);
        },
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
}

// Thêm Meta Box checkbox ở sidebar bên phải
add_action('add_meta_boxes', 'add_post_item_multi_cate_metabox');
function add_post_item_multi_cate_metabox()
{
    add_meta_box(
        'post_item_multi_cate_box',
        'Select Categories',
        'render_post_item_multi_cate_box',
        'post_item',
        'side',
        'default'
    );
}

// Render checkbox list
function render_post_item_multi_cate_box($post)
{
    // Lấy danh sách category hiện tại (array)
    $current_cates = get_post_meta($post->ID, 'id_cate_post', true);
    if (!is_array($current_cates)) {
        $current_cates = array();
    }

    // Lấy tất cả categories từ CPT cate_post
    $categories = get_posts(array(
        'post_type' => 'cate_post',
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));

    wp_nonce_field('post_item_cate_nonce', 'post_item_cate_nonce_field');

    echo '<p><strong>Assign to categories:</strong></p>';
    echo '<div style="max-height:200px; overflow-y:auto; border:1px solid #ddd; padding:10px; border-radius:4px; background:#f9f9f9;">';

    if (empty($categories)) {
        echo '<p style="color:#999;">No categories found.</p>';
    } else {
        foreach ($categories as $cate) {
            $checked = in_array($cate->ID, $current_cates) ? 'checked' : '';
            echo '
                <label style="display:block; margin-bottom:6px; cursor:pointer;">
                    <input 
                        type="checkbox" 
                        name="id_cate_post[]" 
                        value="' . esc_attr($cate->ID) . '" 
                        ' . $checked . '
                        style="margin-right:6px;"
                    >
                    ' . esc_html($cate->post_title) . '
                </label>
            ';
        }
    }

    echo '</div>';
    echo '<p class="description" style="margin-top:8px;">Select one or multiple categories</p>';
}

// Lưu meta khi save post
add_action('save_post_post_item', 'save_post_item_multi_cate_meta', 10, 2);
function save_post_item_multi_cate_meta($post_id, $post)
{
    // Kiểm tra nonce
    if (
        !isset($_POST['post_item_cate_nonce_field']) ||
        !wp_verify_nonce($_POST['post_item_cate_nonce_field'], 'post_item_cate_nonce')
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

    // Xử lý checkbox array
    if (isset($_POST['id_cate_post']) && is_array($_POST['id_cate_post'])) {
        $selected_cates = array_map('intval', $_POST['id_cate_post']);
        update_post_meta($post_id, 'id_cate_post', $selected_cates);
    } else {
        // Nếu không tick gì, lưu array rỗng
        update_post_meta($post_id, 'id_cate_post', array());
    }
}

// Thêm column "Categories" vào admin list
add_filter('manage_post_item_posts_columns', 'add_post_item_cate_column');
function add_post_item_cate_column($columns)
{
    $columns['categories'] = 'Categories';
    return $columns;
}

add_action('manage_post_item_posts_custom_column', 'show_post_item_cate_column', 10, 2);
function show_post_item_cate_column($column, $post_id)
{
    if ($column === 'categories') {
        $cate_ids = get_post_meta($post_id, 'id_cate_post', true);

        if (empty($cate_ids) || !is_array($cate_ids)) {
            echo '<span style="color:#999;">—</span>';
            return;
        }

        $cate_names = array();
        foreach ($cate_ids as $cate_id) {
            $cate = get_post($cate_id);
            if ($cate) {
                $cate_names[] = esc_html($cate->post_title);
            }
        }

        if (!empty($cate_names)) {
            echo implode(', ', $cate_names);
        } else {
            echo '<span style="color:#999;">—</span>';
        }
    }
}
?>