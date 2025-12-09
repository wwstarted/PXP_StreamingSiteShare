<?php
// ========================================
// REGISTER META FIELDS - EXPOSE RA REST API
// ========================================
add_action('init', 'register_blogs_meta_fields');
function register_blogs_meta_fields()
{
    // Short Description
    register_post_meta('blogs', 'bg_short_desc', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));

    // Blog Description (Full content with HTML)
    register_post_meta('blogs', '_blog_desc', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));

    // Thumbnail Image URL
    register_post_meta('blogs', 'bg_thumbnail', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));

    // Visibility Checkbox
    register_post_meta('blogs', '_blogs_visible', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'default' => '1',
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
}

// ========================================
// META BOX 1: BLOG DESCRIPTION (normal + high)
// ========================================
add_action('add_meta_boxes', 'add_blog_desc_metabox');
function add_blog_desc_metabox()
{
    add_meta_box(
        'blog_desc_box',
        'Blog Description',
        'render_blog_desc_metabox',
        'blogs',
        'normal',
        'high'
    );
}

function render_blog_desc_metabox($post)
{
    $desc = get_post_meta($post->ID, '_blog_desc', true);

    wp_nonce_field('blog_desc_nonce', 'blog_desc_nonce_field');

    echo '<div style="margin: 15px 0;">';
    echo '<p class="description" style="margin-bottom: 10px;">Full description with rich text editor</p>';

    wp_editor(
        $desc,
        'blog_desc',
        array(
            'textarea_name' => 'blog_desc',
            'media_buttons' => true,
            'textarea_rows' => 12,
            'teeny' => false,
            'quicktags' => true,
            'tinymce' => array(
                'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                'toolbar2' => 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
            )
        )
    );

    echo '</div>';
}

// ========================================
// META BOX 2: BLOG DETAILS (normal + high)
// ========================================
add_action('add_meta_boxes', 'add_blogs_details_metabox');
function add_blogs_details_metabox()
{
    add_meta_box(
        'blogs_details_box',
        'Blog Details',
        'render_blogs_details_box',
        'blogs',
        'normal',
        'high'
    );
}

function render_blogs_details_box($post)
{
    $short_desc = get_post_meta($post->ID, 'bg_short_desc', true);
    $thumbnail = get_post_meta($post->ID, 'bg_thumbnail', true);
    $thumbnail_id = get_post_meta($post->ID, 'bg_thumbnail_id', true);

    wp_nonce_field('blogs_details_nonce', 'blogs_details_nonce_field');
    ?>

<table class="form-table" style="margin-top: 10px;">
    <tr>
        <th style="width: 200px;">
            <label for="bg_short_desc">Short Description</label>
        </th>
        <td>
            <textarea id="bg_short_desc" name="bg_short_desc" rows="4" style="width: 100%; max-width: 600px;"
                placeholder="Enter a short description for this blog post..."><?php echo esc_textarea($short_desc); ?></textarea>
            <p class="description">Brief summary of the blog post (shown in listings)</p>
        </td>
    </tr>

    <tr>
        <th>
            <label for="bg_thumbnail">Thumbnail Image</label>
        </th>
        <td>
            <div class="blogs-thumbnail-wrapper">
                <input type="hidden" id="bg_thumbnail" name="bg_thumbnail" value="<?php echo esc_url($thumbnail); ?>" />
                <input type="hidden" id="bg_thumbnail_id" name="bg_thumbnail_id"
                    value="<?php echo esc_attr($thumbnail_id); ?>" />

                <div id="thumbnail-preview" style="margin-bottom: 10px;">
                    <?php if ($thumbnail): ?>
                    <img src="<?php echo esc_url($thumbnail); ?>"
                        style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                    <?php else: ?>
                    <p style="color: #999;">No image selected</p>
                    <?php endif; ?>
                </div>

                <button type="button" class="button button-secondary" id="upload_thumbnail_button">
                    <span class="dashicons dashicons-upload" style="margin-top: 3px;"></span>
                    <?php echo $thumbnail ? 'Change Image' : 'Upload Image'; ?>
                </button>

                <?php if ($thumbnail): ?>
                <button type="button" class="button button-link-delete" id="remove_thumbnail_button"
                    style="color: #b32d2e; margin-left: 10px;">
                    Remove Image
                </button>
                <?php endif; ?>
            </div>
            <p class="description">Featured image for the blog post</p>
        </td>
    </tr>
</table>

<script>
jQuery(document).ready(function($) {
    var mediaUploader;

    $('#upload_thumbnail_button').on('click', function(e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Choose Thumbnail Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#bg_thumbnail').val(attachment.url);
            $('#bg_thumbnail_id').val(attachment.id);
            $('#thumbnail-preview').html('<img src="' + attachment.url +
                '" style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 4px;">'
            );
            $('#upload_thumbnail_button').text('Change Image');

            if ($('#remove_thumbnail_button').length === 0) {
                $('#upload_thumbnail_button').after(
                    '<button type="button" class="button button-link-delete" id="remove_thumbnail_button" style="color: #b32d2e; margin-left: 10px;">Remove Image</button>'
                );
            }
        });

        mediaUploader.open();
    });

    $(document).on('click', '#remove_thumbnail_button', function(e) {
        e.preventDefault();
        $('#bg_thumbnail').val('');
        $('#bg_thumbnail_id').val('');
        $('#thumbnail-preview').html('<p style="color: #999;">No image selected</p>');
        $('#upload_thumbnail_button').text('Upload Image');
        $(this).remove();
    });
});
</script>

<?php
}

// ========================================
// META BOX 3: VISIBILITY (side + high)
// ========================================
add_action('add_meta_boxes', 'add_blogs_visibility_metabox');
function add_blogs_visibility_metabox()
{
    add_meta_box(
        'blogs_visibility_box',
        'Hiển thị',
        'render_blogs_visibility_box',
        'blogs',
        'side',
        'high'
    );
}

function render_blogs_visibility_box($post)
{
    $is_visible = get_post_meta($post->ID, '_blogs_visible', true);

    if ($is_visible === '') {
        $is_visible = '1';
    }

    wp_nonce_field('blogs_visibility_nonce', 'blogs_visibility_nonce_field');
    ?>

<div style="padding: 10px 0;">
    <label style="display: flex; align-items: center; cursor: pointer;">
        <input type="checkbox" name="blogs_visible" value="1" <?php checked($is_visible, '1'); ?>
            style="margin-right: 8px;" />
        <span>Show on HomePage</span>
    </label>
    <p class="description" style="margin-top: 8px; color: #666;">
        Tick to display this blog on homepage
    </p>
</div>

<?php
}

// ========================================
// SAVE ALL META DATA - SINGLE HOOK
// ========================================
add_action('save_post_blogs', 'save_blogs_all_meta_data', 10, 2);
function save_blogs_all_meta_data($post_id, $post)
{
    // Kiểm tra autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Kiểm tra quyền
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // === SAVE BLOG DESCRIPTION ===
    if (
        isset($_POST['blog_desc_nonce_field']) &&
        wp_verify_nonce($_POST['blog_desc_nonce_field'], 'blog_desc_nonce')
    ) {

        if (isset($_POST['blog_desc'])) {
            update_post_meta($post_id, '_blog_desc', wp_kses_post($_POST['blog_desc']));
        }
    }

    // === SAVE BLOG DETAILS ===
    if (
        isset($_POST['blogs_details_nonce_field']) &&
        wp_verify_nonce($_POST['blogs_details_nonce_field'], 'blogs_details_nonce')
    ) {

        // Save Short Description
        if (isset($_POST['bg_short_desc'])) {
            update_post_meta($post_id, 'bg_short_desc', sanitize_textarea_field($_POST['bg_short_desc']));
        }

        // Save Thumbnail
        if (isset($_POST['bg_thumbnail'])) {
            update_post_meta($post_id, 'bg_thumbnail', esc_url_raw($_POST['bg_thumbnail']));
        }

        if (isset($_POST['bg_thumbnail_id'])) {
            update_post_meta($post_id, 'bg_thumbnail_id', intval($_POST['bg_thumbnail_id']));
        }
    }

    // === SAVE VISIBILITY ===
    if (
        isset($_POST['blogs_visibility_nonce_field']) &&
        wp_verify_nonce($_POST['blogs_visibility_nonce_field'], 'blogs_visibility_nonce')
    ) {

        $is_visible = isset($_POST['blogs_visible']) ? '1' : '0';
        update_post_meta($post_id, '_blogs_visible', $is_visible);
    }
}

// ========================================
// ADD ADMIN COLUMNS
// ========================================
add_filter('manage_blogs_posts_columns', 'add_blogs_admin_columns');
function add_blogs_admin_columns($columns)
{
    $new_columns = array();

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        if ($key === 'title') {
            $new_columns['thumbnail'] = 'Thumbnail';
        }
    }

    $new_columns['visibility'] = 'Hiển thị';

    return $new_columns;
}

add_action('manage_blogs_posts_custom_column', 'show_blogs_admin_columns', 10, 2);
function show_blogs_admin_columns($column, $post_id)
{
    if ($column === 'thumbnail') {
        $thumbnail = get_post_meta($post_id, 'bg_thumbnail', true);
        if ($thumbnail) {
            echo '<img src="' . esc_url($thumbnail) . '" style="width: 60px; height: auto; border-radius: 4px;">';
        } else {
            echo '<span style="color: #999;">—</span>';
        }
    }

    if ($column === 'visibility') {
        $is_visible = get_post_meta($post_id, '_blogs_visible', true);
        if ($is_visible === '1') {
            echo '<span style="color: #46b450;">✓ Hiển thị</span>';
        } else {
            echo '<span style="color: #dc3232;">✗ Ẩn</span>';
        }
    }
}

add_filter('rest_prepare_blogs', 'add_author_info_to_blogs_api', 10, 3);
function add_author_info_to_blogs_api($response, $post, $request)
{
    $author_id = $post->post_author;

    $author_name = get_the_author_meta('display_name', $author_id);
    $author_avatar = get_avatar_url($author_id, array('size' => 96));

    $response->data['author_name'] = $author_name;
    $response->data['author_avatar'] = $author_avatar;

    return $response;
}
?>