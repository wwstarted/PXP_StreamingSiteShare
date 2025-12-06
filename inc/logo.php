<?php
// ============================================
// 1. TẠO OPTIONS PAGE TRONG ADMIN MENU
// ============================================
function add_site_options_page()
{
    add_options_page(
        'Site Options',           // Tiêu đề trang
        'Site Options',           // Tên menu
        'manage_options',         // Quyền truy cập
        'site-options',           // Slug
        'render_site_options_page' // Callback
    );
}
add_action('admin_menu', 'add_site_options_page');


// ============================================
// 2. RENDER TRANG OPTIONS
// ============================================
function render_site_options_page()
{
    // Kiểm tra quyền
    if (!current_user_can('manage_options')) {
        return;
    }

    // Lấy giá trị đã lưu
    $logo_url = get_option('site_logo_url', '');

    ?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <form method="post" action="options.php">
        <?php
            settings_fields('site_options_group');
            do_settings_sections('site-options');
            ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="site_logo_url">Logo Header</label>
                </th>
                <td>
                    <input type="text" id="site_logo_url" name="site_logo_url" value="<?php echo esc_url($logo_url); ?>"
                        class="regular-text" placeholder="https://example.com/logo.png" />
                    <button type="button" class="button" id="upload_logo_button">
                        Upload Logo
                    </button>

                    <p class="description">
                        Upload ảnh hoặc nhập URL trực tiếp
                    </p>

                    <?php if ($logo_url): ?>
                    <div style="margin-top: 10px;">
                        <img src="<?php echo esc_url($logo_url); ?>"
                            style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;">
                    </div>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <?php submit_button('Save Settings'); ?>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    var mediaUploader;

    $('#upload_logo_button').on('click', function(e) {
        e.preventDefault();

        // Nếu media uploader đã tồn tại, mở lại
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Tạo media uploader mới
        mediaUploader = wp.media({
            title: 'Choose Logo',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        // Khi chọn ảnh
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#site_logo_url').val(attachment.url);

            // Hiển thị preview
            var preview = '<div style="margin-top: 10px;"><img src="' + attachment.url +
                '" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;"></div>';
            $('#site_logo_url').parent().find('div').remove();
            $('#site_logo_url').parent().append(preview);
        });

        mediaUploader.open();
    });
});
</script>
<?php
}


// ============================================
// 3. ĐĂNG KÝ SETTINGS
// ============================================
function register_site_options()
{
    register_setting(
        'site_options_group',  // Option group
        'site_logo_url',       // Option name
        array(
            'type' => 'string',
            'sanitize_callback' => 'esc_url_raw',
            'default' => ''
        )
    );
}
add_action('admin_init', 'register_site_options');


// ============================================
// 4. ĐĂNG KÝ REST API ENDPOINT
// ============================================
function register_site_options_rest_route()
{
    register_rest_route('wp/v2', '/site-options', array(
        'methods' => 'GET',
        'callback' => 'get_site_options_rest',
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init', 'register_site_options_rest_route');

function get_site_options_rest()
{
    return array(
        'logo_url' => get_option('site_logo_url', ''),
    );
}


// ============================================
// 5. ENQUEUE MEDIA UPLOADER (CHO ADMIN)
// ============================================
function enqueue_media_uploader()
{
    if (isset($_GET['page']) && $_GET['page'] === 'site-options') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');