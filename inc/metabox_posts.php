<?php
add_action('add_meta_boxes', 'register_post_details_metabox');

function register_post_details_metabox()
{
    add_meta_box(
        'post_details_metabox',
        'Post Details',
        'render_post_details_metabox',
        'post',
        'normal',
        'high'
    );
}

function render_post_details_metabox($post)
{
    wp_nonce_field('post_details_nonce_action', 'post_details_nonce');

    $bgr_image = get_post_meta($post->ID, 'bgr_image', true);
    $image = get_post_meta($post->ID, 'image', true);
    $logo = get_post_meta($post->ID, 'logo', true);

    $popularity = get_post_meta($post->ID, 'popularity', true);
    $post_link = get_post_meta($post->ID, 'post_link', true);

    $likes_json = get_post_meta($post->ID, 'likes', true);
    $likes = !empty($likes_json) ? json_decode($likes_json, true) : [];

    $hates_json = get_post_meta($post->ID, 'hates', true);
    $hates = !empty($hates_json) ? json_decode($hates_json, true) : [];

    $image_fields = array(
        'bgr_image' => 'Background Image',
        'image' => 'Main Image',
        'logo' => 'Logo'
    );

    ?>
<style>
.post-details-container {
    background: #fff;
}

.metabox-section {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #ddd;
}

.metabox-section:last-child {
    border-bottom: none;
}

.metabox-section h3 {
    margin-top: 0;
    margin-bottom: 15px;
    padding: 10px;
    background: #f0f0f1;
    border-left: 4px solid #2271b1;
}

.image-field-wrapper {
    margin-bottom: 20px;
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
.metabox-field input[type="number"] {
    width: 100%;
    padding: 8px;
}

.repeater-field {
    border: 1px solid #ddd;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 3px;
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

<div class="post-details-container">
    <div class="metabox-section">
        <h3>📸 Image Fields</h3>

        <?php foreach ($image_fields as $field_key => $field_label): ?>
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

    <div class="metabox-section">
        <h3>📝 Post Details</h3>

        <div class="metabox-field">
            <label for="post_popularity">Độ phổ biến (0-100%)</label>
            <input type="number" id="post_popularity" name="post_popularity"
                value="<?php echo esc_attr($popularity); ?>" min="0" max="100" placeholder="0-100">
        </div>

        <div class="metabox-field">
            <label for="post_post_link">Link bên ngoài</label>
            <input type="url" id="post_post_link" name="post_post_link" value="<?php echo esc_url($post_link); ?>"
                placeholder="https://example.com">
        </div>

        <div class="metabox-field">
            <label>Đánh giá tốt (Likes)</label>
            <div class="repeater-field" id="likes-repeater">
                <?php if (!empty($likes) && is_array($likes)): ?>
                <?php foreach ($likes as $like): ?>
                <div class="repeater-item">
                    <input type="text" name="post_likes[]" value="<?php echo esc_attr($like); ?>"
                        placeholder="Nhập đánh giá tốt">
                    <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="repeater-item">
                    <input type="text" name="post_likes[]" value="" placeholder="Nhập đánh giá tốt">
                    <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                </div>
                <?php endif; ?>
            </div>
            <button type="button" class="add-repeater-btn" onclick="addLikeField()">+ Add Like</button>
        </div>

        <div class="metabox-field">
            <label>Đánh giá không tốt (Hates)</label>
            <div class="repeater-field" id="hates-repeater">
                <?php if (!empty($hates) && is_array($hates)): ?>
                <?php foreach ($hates as $hate): ?>
                <div class="repeater-item">
                    <input type="text" name="post_hates[]" value="<?php echo esc_attr($hate); ?>"
                        placeholder="Nhập đánh giá không tốt">
                    <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="repeater-item">
                    <input type="text" name="post_hates[]" value="" placeholder="Nhập đánh giá không tốt">
                    <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                </div>
                <?php endif; ?>
            </div>
            <button type="button" class="add-repeater-btn" onclick="addHateField()">+ Add Hate</button>
        </div>

    </div>

</div>

<script>
jQuery(document).ready(function($) {
    $('.upload-image-btn').on('click', function(e) {
        e.preventDefault();

        var button = $(this);
        var fieldName = button.data('field');
        var customUploader;

        if (customUploader) {
            customUploader.open();
            return;
        }

        customUploader = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        customUploader.on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();

            $('#' + fieldName).val(attachment.url);

            $('#preview-' + fieldName).html('<img src="' + attachment.url + '" alt="Preview">');
        });

        customUploader.open();
    });

    $('.remove-image-btn').on('click', function(e) {
        e.preventDefault();

        var button = $(this);
        var fieldName = button.data('field');

        $('#' + fieldName).val('');

        $('#preview-' + fieldName).html('<span class="no-image">No image selected</span>');
    });
});

function addLikeField() {
    const container = document.getElementById('likes-repeater');
    const newField = document.createElement('div');
    newField.className = 'repeater-item';
    newField.innerHTML = `
        <input type="text" name="post_likes[]" value="" placeholder="Nhập đánh giá tốt">
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
    `;
    container.appendChild(newField);
}

function addHateField() {
    const container = document.getElementById('hates-repeater');
    const newField = document.createElement('div');
    newField.className = 'repeater-item';
    newField.innerHTML = `
        <input type="text" name="post_hates[]" value="" placeholder="Nhập đánh giá không tốt">
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
    `;
    container.appendChild(newField);
}
</script>
<?php
}

add_action('admin_enqueue_scripts', 'enqueue_post_media_uploader');

function enqueue_post_media_uploader($hook)
{
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        global $post_type;
        if ('post' === $post_type) {
            wp_enqueue_media();
        }
    }
}
add_action('save_post', 'save_post_details_meta');

function save_post_details_meta($post_id)
{
    if (
        !isset($_POST['post_details_nonce']) ||
        !wp_verify_nonce($_POST['post_details_nonce'], 'post_details_nonce_action')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (get_post_type($post_id) !== 'post') {
        return;
    }

    $image_fields = array('bgr_image', 'image', 'logo');
    foreach ($image_fields as $field) {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, $field, esc_url_raw($value));
        }
    }

    if (isset($_POST['post_popularity'])) {
        $popularity = intval($_POST['post_popularity']);
        $popularity = max(0, min(100, $popularity)); // Giới hạn 0-100
        update_post_meta($post_id, 'popularity', $popularity);
    }

    if (isset($_POST['post_post_link'])) {
        update_post_meta($post_id, 'post_link', esc_url_raw($_POST['post_post_link']));
    }

    if (isset($_POST['post_likes']) && is_array($_POST['post_likes'])) {
        $likes = array_filter(array_map('sanitize_text_field', $_POST['post_likes']));
        update_post_meta($post_id, 'likes', json_encode(array_values($likes)));
    } else {
        update_post_meta($post_id, 'likes', json_encode([]));
    }

    if (isset($_POST['post_hates']) && is_array($_POST['post_hates'])) {
        $hates = array_filter(array_map('sanitize_text_field', $_POST['post_hates']));
        update_post_meta($post_id, 'hates', json_encode(array_values($hates)));
    } else {
        update_post_meta($post_id, 'hates', json_encode([]));
    }
}


add_action('rest_api_init', 'register_post_meta_in_rest');

function register_post_meta_in_rest()
{
    $meta_fields = [
        'bgr_image',
        'image',
        'logo',
        'popularity',
        'post_link',
        'likes',
        'hates'
    ];

    foreach ($meta_fields as $field) {
        register_rest_field(
            'post',
            $field,
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