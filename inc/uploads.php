<?php

// 1. REGISTER META BOX
add_action('add_meta_boxes', 'register_post_item_image_metabox');

function register_post_item_image_metabox()
{
    add_meta_box(
        'post_item_images_metabox',           // ID
        'Image Fields',                        // Tiêu đề
        'render_post_item_images_metabox',    // Callback
        'post_item',                          // Post type
        'normal',                             // Context
        'high'                                // Priority
    );
}

// 2. RENDER META BOX HTML
function render_post_item_images_metabox($post)
{
    // Nonce field để bảo mật
    wp_nonce_field('post_item_images_nonce_action', 'post_item_images_nonce');

    // Lấy giá trị hiện tại
    $author_logo = get_post_meta($post->ID, 'author_logo', true);
    $bgr_image = get_post_meta($post->ID, 'bgr_image', true);
    $image = get_post_meta($post->ID, 'image', true);
    $logo = get_post_meta($post->ID, 'logo', true);

    // Định nghĩa các fields
    $fields = array(
        'author_logo' => 'Author Logo',
        'bgr_image' => 'Background Image',
        'image' => 'Main Image',
        'logo' => 'Logo'
    );

    ?>
<style>
.image-field-wrapper {
    margin-bottom: 25px;
    padding: 15px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.image-field-wrapper label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #23282d;
}

.image-input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.image-input-group input[type="text"] {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 3px;
}

.upload-image-btn,
.remove-image-btn {
    padding: 8px 15px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s;
}

.upload-image-btn {
    background: #0073aa;
    color: white;
}

.upload-image-btn:hover {
    background: #005177;
}

.remove-image-btn {
    background: #dc3232;
    color: white;
}

.remove-image-btn:hover {
    background: #a00;
}

.image-preview {
    margin-top: 10px;
}

.image-preview img {
    max-width: 200px;
    max-height: 200px;
    border: 2px solid #ddd;
    border-radius: 5px;
    display: block;
}

.no-image {
    color: #999;
    font-style: italic;
}
</style>

<div class="post-item-images-container">
    <?php foreach ($fields as $field_key => $field_label): ?>
    <?php $field_value = get_post_meta($post->ID, $field_key, true); ?>

    <div class="image-field-wrapper">
        <label for="<?php echo $field_key; ?>"><?php echo $field_label; ?></label>

        <div class="image-input-group">
            <input type="text" id="<?php echo $field_key; ?>" name="<?php echo $field_key; ?>"
                value="<?php echo esc_url($field_value); ?>" placeholder="Enter image URL or click Upload" />
            <button type="button" class="upload-image-btn" data-field="<?php echo $field_key; ?>">
                📤 Upload
            </button>
            <button type="button" class="remove-image-btn" data-field="<?php echo $field_key; ?>">
                ❌ Remove
            </button>
        </div>

        <div class="image-preview" id="preview-<?php echo $field_key; ?>">
            <?php if ($field_value): ?>
            <img src="<?php echo esc_url($field_value); ?>" alt="<?php echo $field_label; ?>">
            <?php else: ?>
            <span class="no-image">No image selected</span>
            <?php endif; ?>
        </div>
    </div>

    <?php endforeach; ?>
</div>

<script>
jQuery(document).ready(function($) {
    // Upload button click
    $('.upload-image-btn').on('click', function(e) {
        e.preventDefault();

        var button = $(this);
        var fieldName = button.data('field');
        var customUploader;

        // Nếu media frame đã tồn tại, mở lại
        if (customUploader) {
            customUploader.open();
            return;
        }

        // Tạo media frame
        customUploader = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        // Khi chọn image
        customUploader.on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();

            // Set URL vào input
            $('#' + fieldName).val(attachment.url);

            // Update preview
            $('#preview-' + fieldName).html('<img src="' + attachment.url + '" alt="Preview">');
        });

        // Mở media frame
        customUploader.open();
    });

    // Remove button click
    $('.remove-image-btn').on('click', function(e) {
        e.preventDefault();

        var button = $(this);
        var fieldName = button.data('field');

        // Clear input
        $('#' + fieldName).val('');

        // Clear preview
        $('#preview-' + fieldName).html('<span class="no-image">No image selected</span>');
    });
});
</script>
<?php
}

// 3. ENQUEUE MEDIA LIBRARY SCRIPT
add_action('admin_enqueue_scripts', 'enqueue_post_item_media_uploader');

function enqueue_post_item_media_uploader($hook)
{
    // Chỉ load trên post edit screen của post_item
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        global $post_type;
        if ('post_item' === $post_type) {
            wp_enqueue_media();
        }
    }
}

// 4. SAVE META DATA
add_action('save_post', 'save_post_item_images_meta');

function save_post_item_images_meta($post_id)
{
    // Kiểm tra nonce
    if (
        !isset($_POST['post_item_images_nonce']) ||
        !wp_verify_nonce($_POST['post_item_images_nonce'], 'post_item_images_nonce_action')
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
    if (get_post_type($post_id) !== 'post_item') {
        return;
    }

    // Danh sách các fields cần save
    $fields = array('author_logo', 'bgr_image', 'image', 'logo');

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, $field, esc_url_raw($value));
        }
    }
}

// 5. REGISTER REST API FIELDS
add_action('rest_api_init', 'register_post_item_image_fields_in_rest');

function register_post_item_image_fields_in_rest()
{
    $fields = array('author_logo', 'bgr_image', 'image', 'logo');

    foreach ($fields as $field) {
        register_rest_field(
            'post_item',           // Post type
            $field,                // Field name trong API
            array(
                'get_callback' => function ($object) use ($field) {
                    return get_post_meta($object['id'], $field, true);
                },
                'update_callback' => function ($value, $object) use ($field) {
                    return update_post_meta($object->ID, $field, sanitize_text_field($value));
                },
                'schema' => array(
                    'type' => 'string',
                    'description' => ucfirst(str_replace('_', ' ', $field)),
                    'context' => array('view', 'edit')
                )
            )
        );
    }
}

// ============================================
// 1. ĐĂNG KÝ METABOX
// ============================================
function register_post_item_metabox()
{
    add_meta_box(
        'post_item_details',           // ID
        'Post Item Details',            // Title
        'render_post_item_metabox',     // Callback
        'post_item',                    // Post type
        'normal',                       // Context
        'high'                          // Priority
    );
}
add_action('add_meta_boxes', 'register_post_item_metabox');


// ============================================
// 2. RENDER METABOX HTML
// ============================================
function render_post_item_metabox($post)
{
    // Nonce field cho bảo mật
    wp_nonce_field('save_post_item_metabox', 'post_item_metabox_nonce');

    // Lấy dữ liệu hiện tại
    $author = get_post_meta($post->ID, 'author', true);
    $date = get_post_meta($post->ID, 'date', true);
    $popularity = get_post_meta($post->ID, 'popularity', true);
    $post_link = get_post_meta($post->ID, 'post_link', true);

    // Lấy likes và hates (JSON decode)
    $likes_json = get_post_meta($post->ID, 'likes', true);
    $likes = !empty($likes_json) ? json_decode($likes_json, true) : [];

    $hates_json = get_post_meta($post->ID, 'hates', true);
    $hates = !empty($hates_json) ? json_decode($hates_json, true) : [];

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

.metabox-field input[type="text"],
.metabox-field input[type="url"],
.metabox-field input[type="date"],
.metabox-field input[type="number"] {
    width: 100%;
    padding: 8px;
}

.repeater-field {
    border: 1px solid #ddd;
    padding: 15px;
    background: #f9f9f9;
}

.repeater-item {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    align-items: center;
}

.repeater-item input {
    flex: 1;
    padding: 8px;
}

.repeater-item .remove-btn {
    background: #dc3232;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 3px;
}

.repeater-item .remove-btn:hover {
    background: #a00;
}

.add-repeater-btn {
    background: #2271b1;
    color: white;
    border: none;
    padding: 8px 15px;
    cursor: pointer;
    border-radius: 3px;
    margin-top: 10px;
}

.add-repeater-btn:hover {
    background: #135e96;
}
</style>

<!-- Author -->
<div class="metabox-field">
    <label for="post_item_author">Tên tác giả</label>
    <input type="text" id="post_item_author" name="post_item_author" value="<?php echo esc_attr($author); ?>"
        placeholder="Nhập tên tác giả">
</div>

<!-- Date -->
<div class="metabox-field">
    <label for="post_item_date">Ngày xuất bản</label>
    <input type="date" id="post_item_date" name="post_item_date" value="<?php echo esc_attr($date); ?>">
</div>

<!-- Popularity -->
<div class="metabox-field">
    <label for="post_item_popularity">Độ phổ biến (0-100%)</label>
    <input type="number" id="post_item_popularity" name="post_item_popularity"
        value="<?php echo esc_attr($popularity); ?>" min="0" max="100" placeholder="0-100">
</div>

<!-- Post Link -->
<div class="metabox-field">
    <label for="post_item_post_link">Link bên ngoài</label>
    <input type="url" id="post_item_post_link" name="post_item_post_link" value="<?php echo esc_url($post_link); ?>"
        placeholder="https://example.com">
</div>

<!-- Likes (Repeater) -->
<div class="metabox-field">
    <label>Đánh giá tốt (Likes)</label>
    <div class="repeater-field" id="likes-repeater">
        <?php if (!empty($likes) && is_array($likes)): ?>
        <?php foreach ($likes as $like): ?>
        <div class="repeater-item">
            <input type="text" name="post_item_likes[]" value="<?php echo esc_attr($like); ?>"
                placeholder="Nhập đánh giá tốt">
            <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="repeater-item">
            <input type="text" name="post_item_likes[]" value="" placeholder="Nhập đánh giá tốt">
            <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
        </div>
        <?php endif; ?>
    </div>
    <button type="button" class="add-repeater-btn" onclick="addLikeField()">+ Add Like</button>
</div>

<!-- Hates (Repeater) -->
<div class="metabox-field">
    <label>Đánh giá không tốt (Hates)</label>
    <div class="repeater-field" id="hates-repeater">
        <?php if (!empty($hates) && is_array($hates)): ?>
        <?php foreach ($hates as $hate): ?>
        <div class="repeater-item">
            <input type="text" name="post_item_hates[]" value="<?php echo esc_attr($hate); ?>"
                placeholder="Nhập đánh giá không tốt">
            <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="repeater-item">
            <input type="text" name="post_item_hates[]" value="" placeholder="Nhập đánh giá không tốt">
            <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
        </div>
        <?php endif; ?>
    </div>
    <button type="button" class="add-repeater-btn" onclick="addHateField()">+ Add Hate</button>
</div>

<script>
function addLikeField() {
    const container = document.getElementById('likes-repeater');
    const newField = document.createElement('div');
    newField.className = 'repeater-item';
    newField.innerHTML = `
                <input type="text" name="post_item_likes[]" value="" placeholder="Nhập đánh giá tốt">
                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                `;
    container.appendChild(newField);
}

function addHateField() {
    const container = document.getElementById('hates-repeater');
    const newField = document.createElement('div');
    newField.className = 'repeater-item';
    newField.innerHTML = `
                <input type="text" name="post_item_hates[]" value="" placeholder="Nhập đánh giá không tốt">
                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                `;
    container.appendChild(newField);
}
</script>
<?php
}


// ============================================
// 3. LƯU DỮ LIỆU METABOX
// ============================================
function save_post_item_metabox($post_id)
{
    // Kiểm tra nonce
    if (
        !isset($_POST['post_item_metabox_nonce']) ||
        !wp_verify_nonce($_POST['post_item_metabox_nonce'], 'save_post_item_metabox')
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
    if (get_post_type($post_id) !== 'post_item') {
        return;
    }

    // Lưu Author
    if (isset($_POST['post_item_author'])) {
        update_post_meta($post_id, 'author', sanitize_text_field($_POST['post_item_author']));
    }

    // Lưu Date
    if (isset($_POST['post_item_date'])) {
        update_post_meta($post_id, 'date', sanitize_text_field($_POST['post_item_date']));
    }

    // Lưu Popularity
    if (isset($_POST['post_item_popularity'])) {
        $popularity = intval($_POST['post_item_popularity']);
        $popularity = max(0, min(100, $popularity)); // Giới hạn 0-100
        update_post_meta($post_id, 'popularity', $popularity);
    }

    // Lưu Post Link
    if (isset($_POST['post_item_post_link'])) {
        update_post_meta($post_id, 'post_link', esc_url_raw($_POST['post_item_post_link']));
    }

    // Lưu Likes (JSON)
    if (isset($_POST['post_item_likes']) && is_array($_POST['post_item_likes'])) {
        $likes = array_filter(array_map('sanitize_text_field', $_POST['post_item_likes']));
        update_post_meta($post_id, 'likes', json_encode(array_values($likes)));
    } else {
        update_post_meta($post_id, 'likes', json_encode([]));
    }

    // Lưu Hates (JSON)
    if (isset($_POST['post_item_hates']) && is_array($_POST['post_item_hates'])) {
        $hates = array_filter(array_map('sanitize_text_field', $_POST['post_item_hates']));
        update_post_meta($post_id, 'hates', json_encode(array_values($hates)));
    } else {
        update_post_meta($post_id, 'hates', json_encode([]));
    }
}
add_action('save_post', 'save_post_item_metabox');


// ============================================
// 4. ĐĂNG KÝ META FIELDS TRONG REST API
// ============================================
function register_post_item_meta_in_rest()
{
    $meta_fields = [
        'author',
        'date',
        'popularity',
        'post_link',
        'likes',
        'hates'
    ];

    foreach ($meta_fields as $field) {
        register_post_meta('post_item', $field, [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]);
    }

    // Đăng ký content field
    register_post_meta('post_item', '_post_item_content', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ]);
}
add_action('rest_api_init', 'register_post_item_meta_in_rest');


// ====================================metabox content =============================
// ==================== METABOX - MAIN CONTENT ====================
function add_post_item_content_metabox()
{
    add_meta_box(
        'post_item_content_box',              // ID
        'Post Item Main Content',             // Tiêu đề box
        'render_post_item_content_metabox',   // Callback
        'post_item',                          // CPT
        'normal',                             // Vị trí
        'high'                                // Ưu tiên
    );
}
add_action('add_meta_boxes', 'add_post_item_content_metabox');

// Hiển thị trình soạn thảo
function render_post_item_content_metabox($post)
{
    // Lấy dữ liệu đã lưu
    $content = get_post_meta($post->ID, '_post_item_content', true);

    wp_editor(
        $content,
        'post_item_content',
        array(
            'textarea_name' => 'post_item_content',
            'media_buttons' => true,    // Cho phép chèn ảnh
            'textarea_rows' => 10,
            'teeny' => false,           // Toolbar đầy đủ
            'quicktags' => true,        // HTML nhanh
        )
    );
}

// Lưu dữ liệu content
function save_post_item_content_metabox($post_id)
{
    // Kiểm tra autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Kiểm tra quyền
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Kiểm tra post type
    if (get_post_type($post_id) !== 'post_item') {
        return;
    }

    // Lưu content
    if (isset($_POST['post_item_content'])) {
        update_post_meta($post_id, '_post_item_content', wp_kses_post($_POST['post_item_content']));
    }
}
add_action('save_post', 'save_post_item_content_metabox');