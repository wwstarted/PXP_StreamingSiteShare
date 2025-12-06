<?php

// ============================================
// 1. ĐĂNG KÝ METABOX
// ============================================
function register_cate_post_metabox()
{
    add_meta_box(
        'cate_post_details',              // ID
        'Category Details',                // Title
        'render_cate_post_metabox',        // Callback
        'cate_post',                       // Post type
        'normal',                          // Context
        'high'                             // Priority
    );
}
add_action('add_meta_boxes', 'register_cate_post_metabox');


// ============================================
// 2. RENDER METABOX HTML
// ============================================
function render_cate_post_metabox($post)
{
    // Nonce field cho bảo mật
    wp_nonce_field('save_cate_post_metabox', 'cate_post_metabox_nonce');

    // Lấy dữ liệu hiện tại
    $short_desc = get_post_meta($post->ID, 'short_desc', true);
    $thumbnail = get_post_meta($post->ID, 'thumbnail', true);

    ?>
<style>
.metabox-field {
    margin-bottom: 20px;
}

.metabox-field label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.metabox-field textarea {
    width: 100%;
    padding: 8px;
    min-height: 100px;
}

.metabox-field input[type="text"] {
    width: 100%;
    padding: 8px;
}

.upload-button {
    background: #2271b1;
    color: white;
    border: none;
    padding: 8px 15px;
    cursor: pointer;
    border-radius: 3px;
    margin-left: 10px;
}

.upload-button:hover {
    background: #135e96;
}

.thumbnail-preview {
    margin-top: 10px;
    max-width: 300px;
    border: 1px solid #ddd;
    padding: 10px;
    background: #f9f9f9;
}

.thumbnail-preview img {
    max-width: 100%;
    height: auto;
    display: block;
}
</style>

<!-- Short Description -->
<div class="metabox-field">
    <label for="cate_post_short_desc">Mô tả ngắn</label>
    <textarea id="cate_post_short_desc" name="cate_post_short_desc"
        placeholder="Nhập mô tả ngắn cho category..."><?php echo esc_textarea($short_desc); ?></textarea>
    <p class="description">Mô tả ngắn sẽ hiển thị ở trang danh sách category</p>
</div>

<!-- Thumbnail -->
<div class="metabox-field">
    <label for="cate_post_thumbnail">Thumbnail (Ảnh đại diện)</label>
    <div style="display: flex; align-items: center;">
        <input type="text" id="cate_post_thumbnail" name="cate_post_thumbnail"
            value="<?php echo esc_url($thumbnail); ?>" placeholder="https://example.com/image.jpg" style="flex: 1;" />
        <button type="button" class="upload-button" id="upload_thumbnail_button">
            Upload Image
        </button>
    </div>
    <p class="description">Upload ảnh hoặc nhập URL trực tiếp</p>

    <?php if ($thumbnail): ?>
    <div class="thumbnail-preview" id="thumbnail-preview">
        <img src="<?php echo esc_url($thumbnail); ?>" alt="Thumbnail Preview">
    </div>
    <?php else: ?>
    <div class="thumbnail-preview" id="thumbnail-preview" style="display: none;">
        <img src="" alt="Thumbnail Preview">
    </div>
    <?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) {
    var mediaUploader;

    $('#upload_thumbnail_button').on('click', function(e) {
        e.preventDefault();

        // Nếu media uploader đã tồn tại, mở lại
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Tạo media uploader mới
        mediaUploader = wp.media({
            title: 'Choose Thumbnail',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        // Khi chọn ảnh
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#cate_post_thumbnail').val(attachment.url);

            // Hiển thị preview
            $('#thumbnail-preview').show();
            $('#thumbnail-preview img').attr('src', attachment.url);
        });

        mediaUploader.open();
    });

    // Preview khi nhập URL thủ công
    $('#cate_post_thumbnail').on('input', function() {
        var url = $(this).val();
        if (url) {
            $('#thumbnail-preview').show();
            $('#thumbnail-preview img').attr('src', url);
        } else {
            $('#thumbnail-preview').hide();
        }
    });
});
</script>
<?php
}


// ============================================
// 3. LƯU DỮ LIỆU METABOX
// ============================================
function save_cate_post_metabox($post_id)
{
    // Kiểm tra nonce
    if (
        !isset($_POST['cate_post_metabox_nonce']) ||
        !wp_verify_nonce($_POST['cate_post_metabox_nonce'], 'save_cate_post_metabox')
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

    // Kiểm tra post type
    if (get_post_type($post_id) !== 'cate_post') {
        return;
    }

    // Lưu Short Description
    if (isset($_POST['cate_post_short_desc'])) {
        update_post_meta($post_id, 'short_desc', sanitize_textarea_field($_POST['cate_post_short_desc']));
    }

    // Lưu Thumbnail
    if (isset($_POST['cate_post_thumbnail'])) {
        update_post_meta($post_id, 'thumbnail', esc_url_raw($_POST['cate_post_thumbnail']));
    }
}
add_action('save_post', 'save_cate_post_metabox');


// ============================================
// 4. ĐĂNG KÝ META FIELDS TRONG REST API
// ============================================
function register_cate_post_meta_in_rest()
{
    $meta_fields = [
        'short_desc',
        'thumbnail'
    ];

    foreach ($meta_fields as $field) {
        register_post_meta('cate_post', $field, [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]);
    }
}
add_action('rest_api_init', 'register_cate_post_meta_in_rest');


// ============================================
// 5. ENQUEUE MEDIA UPLOADER (CHO ADMIN)
// ============================================
function enqueue_cate_post_media_uploader($hook)
{
    global $post_type;

    // Chỉ load media uploader cho cate_post edit screen
    if (('post.php' === $hook || 'post-new.php' === $hook) && 'cate_post' === $post_type) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'enqueue_cate_post_media_uploader');