<?php

// ============================================
// 1. REGISTER TERM META FOR CATEGORY
// ============================================
add_action('init', 'register_category_term_meta');
function register_category_term_meta()
{
    // Thumbnail
    register_term_meta('category', 'thumbnail', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Visibility
    register_term_meta('category', '_cate_visible', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'default' => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));
}

// ============================================
// 2. ADD FIELDS TO "ADD NEW CATEGORY" FORM
// ============================================
add_action('category_add_form_fields', 'add_category_custom_fields');
function add_category_custom_fields()
{
    ?>
<!-- Thumbnail -->
<div class="form-field">
    <label for="category_thumbnail">Thumbnail (Ảnh đại diện)</label>
    <div style="display: flex; gap: 10px; align-items: center;">
        <input type="text" id="category_thumbnail" name="category_thumbnail" value=""
            placeholder="https://example.com/image.jpg" style="flex: 1;" />
        <button type="button" class="button" id="upload_category_thumbnail">Upload Image</button>
    </div>
    <p class="description">Upload ảnh hoặc nhập URL trực tiếp</p>
    <div id="category-thumbnail-preview" style="margin-top: 10px; display: none;">
        <img src="" alt="Preview" style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
    </div>
</div>

<!-- Visibility -->
<div class="form-field">
    <label>
        <input type="checkbox" name="category_visible" value="1" checked />
        Show in homepage
    </label>
    <p class="description">Tick để hiển thị category này</p>
</div>
<?php
}

// ============================================
// 3. ADD FIELDS TO "EDIT CATEGORY" FORM
// ============================================
add_action('category_edit_form_fields', 'edit_category_custom_fields', 10, 1);
function edit_category_custom_fields($term)
{
    $thumbnail = get_term_meta($term->term_id, 'thumbnail', true);
    $is_visible = get_term_meta($term->term_id, '_cate_visible', true);

    // Default visible = 1
    if ($is_visible === '') {
        $is_visible = '1';
    }
    ?>

<!-- Thumbnail -->
<tr class="form-field">
    <th scope="row">
        <label for="category_thumbnail">Thumbnail</label>
    </th>
    <td>
        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
            <input type="text" id="category_thumbnail" name="category_thumbnail"
                value="<?php echo esc_url($thumbnail); ?>" placeholder="https://example.com/image.jpg"
                style="width: 400px;" />
            <button type="button" class="button" id="upload_category_thumbnail">Upload Image</button>
        </div>

        <?php if ($thumbnail): ?>
        <div id="category-thumbnail-preview">
            <img src="<?php echo esc_url($thumbnail); ?>" alt="Preview"
                style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
        </div>
        <?php else: ?>
        <div id="category-thumbnail-preview" style="display: none;">
            <img src="" alt="Preview" style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
        </div>
        <?php endif; ?>

        <p class="description">Upload ảnh hoặc nhập URL trực tiếp</p>
    </td>
</tr>

<!-- Visibility -->
<tr class="form-field">
    <th scope="row">
        <label>Hiển thị</label>
    </th>
    <td>
        <label>
            <input type="checkbox" name="category_visible" value="1" <?php checked($is_visible, '1'); ?> />
            Show in homepage
        </label>
        <p class="description">Tick để hiển thị category này</p>
    </td>
</tr>
<?php
}

// ============================================
// 4. SAVE TERM META
// ============================================
add_action('created_category', 'save_category_custom_fields');
add_action('edited_category', 'save_category_custom_fields');

function save_category_custom_fields($term_id)
{
    // Save Thumbnail
    if (isset($_POST['category_thumbnail'])) {
        update_term_meta($term_id, 'thumbnail', esc_url_raw($_POST['category_thumbnail']));
    }

    // Save Visibility
    $is_visible = isset($_POST['category_visible']) ? '1' : '0';
    update_term_meta($term_id, '_cate_visible', $is_visible);
}

// ============================================
// 5. ADD CUSTOM COLUMNS TO CATEGORY LIST
// ============================================
add_filter('manage_edit-category_columns', 'add_category_custom_columns');
function add_category_custom_columns($columns)
{
    // Thêm column Thumbnail và Visibility
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'name') {
            $new_columns['thumbnail'] = 'Thumbnail';
        }
    }
    $new_columns['visibility'] = 'Hiển thị';
    return $new_columns;
}

add_filter('manage_category_custom_column', 'show_category_custom_columns', 10, 3);
function show_category_custom_columns($content, $column_name, $term_id)
{
    if ($column_name === 'thumbnail') {
        $thumbnail = get_term_meta($term_id, 'thumbnail', true);
        if ($thumbnail) {
            $content = '<img src="' . esc_url($thumbnail) . '" alt="Thumbnail" style="max-width: 50px; height: auto; border-radius: 3px;">';
        } else {
            $content = '<span style="color: #999;">—</span>';
        }
    }

    if ($column_name === 'visibility') {
        $is_visible = get_term_meta($term_id, '_cate_visible', true);
        if ($is_visible === '1' || $is_visible === '') {
            $content = '<span style="color: #46b450;">✓ Hiển thị</span>';
        } else {
            $content = '<span style="color: #dc3232;">✗ Ẩn</span>';
        }
    }

    return $content;
}

// ============================================
// 6. ENQUEUE MEDIA UPLOADER FOR CATEGORY
// ============================================
add_action('admin_enqueue_scripts', 'enqueue_category_media_uploader');
function enqueue_category_media_uploader($hook)
{
    // Load only on category add/edit pages
    if ($hook === 'term.php' || $hook === 'edit-tags.php') {
        wp_enqueue_media();
        ?>
<script>
jQuery(document).ready(function($) {
    var mediaUploader;

    $('#upload_category_thumbnail').on('click', function(e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Choose Category Thumbnail',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#category_thumbnail').val(attachment.url);

            // Show preview
            $('#category-thumbnail-preview').show();
            $('#category-thumbnail-preview img').attr('src', attachment.url);
        });

        mediaUploader.open();
    });

    // Preview when manually entering URL
    $('#category_thumbnail').on('input', function() {
        var url = $(this).val();
        if (url) {
            $('#category-thumbnail-preview').show();
            $('#category-thumbnail-preview img').attr('src', url);
        } else {
            $('#category-thumbnail-preview').hide();
        }
    });
});
</script>
<?php
    }
}

// ============================================
// 7. HELPER FUNCTION - GET VISIBLE CATEGORIES
// ============================================
/**
 * Lấy danh sách categories có visibility = 1
 * Sử dụng: $visible_cats = get_visible_categories();
 */
function get_visible_categories($args = array())
{
    $default_args = array(
        'taxonomy' => 'category',
        'hide_empty' => false,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_cate_visible',
                'value' => '1',
                'compare' => '='
            ),
            array(
                'key' => '_cate_visible',
                'compare' => 'NOT EXISTS' // Mặc định hiển thị nếu chưa set
            )
        )
    );

    $args = wp_parse_args($args, $default_args);
    return get_terms($args);
}