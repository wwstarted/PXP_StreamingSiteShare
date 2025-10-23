<?php
 /**=================== Load ASSETS ====================== */
function load_assets() {
    // Font Awesome CSS
    wp_enqueue_style(
        'fontawesome',
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
        array(),
        '6.5.0'
    );

    // CSS chính
    wp_enqueue_style(
        'maincss',
        get_theme_file_uri('/css/style.css'),
        array(),
        '1.0.1',
        'all'
    );
    
    wp_enqueue_style(
        'maincss1',
        get_theme_file_uri('/css/blog_detail.css'),
        array(),
        '1.0.1',
        'all'
    );
    
    wp_enqueue_style(
        'maincss2',
        get_theme_file_uri('/css/blog.css'),
        array(),
        '1.0.1',
        'all'
    );
    
    wp_enqueue_style(
        'maincss3',
        get_theme_file_uri('/css/home.css'),
        array(),
        '1.0.1',
        'all'
    );   

    wp_enqueue_style(
        'maincss4',
        get_theme_file_uri('/css/categories.css'),
        array(),
        '1.0.1',
        'all'
    );

    // Font Awesome Kit JS
    // wp_enqueue_script(
    //     'fontawesome-kit',
    //     'https://kit.fontawesome.com/a076d05399.js',
    //     array(),
    //     null,
    //     true
    // );

    // JS chính
    wp_enqueue_script(
        'streamingsite-main',
        get_theme_file_uri('/js/categores.js'),
        array('jquery'),
        '1.02',
        true
    );

    wp_enqueue_script(
        'streamingsite-main',
        get_theme_file_uri('/js/home.js'),
        array('jquery'),
        '1.02',
        true
    );
}

add_action('wp_enqueue_scripts', 'load_assets');


 /**=================== REGISTER MENU ====================== */
function register_my_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu')
    ));
}
add_action('init', 'register_my_menus');


function register_my_footer_menus() {
    register_nav_menus(array(
        'footer-menu' => __('Footer Menu')
    ));
}
add_action('init', 'register_my_footer_menus');






/*================ REST API & fetch DATA =======================*/

/** ============= Register CPT ============== */

/** CPT BANNER */
function create_banner_cpt() {
    $labels = array(
        'name' => 'Banners',
        'singular_name' => 'Banner',
        'menu_name' => 'Banners',
        'all_items' => 'All Banners',
        'add_new_item' => 'Add New Banner',
        'edit_item' => 'Edit Banner'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true // quan trọng: enable REST API
    );

    register_post_type('banner', $args);
}
add_action('init', 'create_banner_cpt');

 /** CPT Categories */
function create_cate_post_type() {
  register_post_type('cate_post', [
    'labels' => [
      'name' => 'Categories',
      'singular_name' => 'Category',
      'menu_name' => 'Categories',
      'all_items' => 'All Categories',
      'add_new_item' => 'Add New Category',
      'edit_item' => 'Edit Category'
    ],
    'public' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'thumbnail', 'custom-fields'],
  ]);
}
add_action('init', 'create_cate_post_type');

/** CPT POST */
function create_post_item_type() {
  register_post_type('post_item', [
    'labels' => [
      'name' => 'Posts',
      'singular_name' => 'Post',
      'menu_name' => 'Posts',
      'all_items' => 'All Posts',
      'add_new_item' => 'Add New Post',
      'edit_item' => 'Edit Post'
    ],
    'public' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'custom-fields'],
  ]);
}
add_action('init', 'create_post_item_type');


/** CPT Car Blog */
function create_cars_blogs_item_type() {
  register_post_type('cars_blog', [
    'labels' => [
      'name' => 'Cars Blogs',
      'singular_name' => 'Cars Blog',
      'menu_name' => 'Cars Blogs',
      'all_items' => 'All Cars Blogs',
      'add_new_item' => 'Add Cars Blogs',
      'edit_item' => 'Edit Cars Blogs'
    ],
    'public' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'custom-fields'],
  ]);
}
add_action('init', 'create_cars_blogs_item_type');

/** CPT Categories Banner */
function create_cate_banner_post_type() {
  register_post_type('cate_banner', [
    'labels' => [
      'name' => 'Categories Banners',
      'singular_name' => 'Categories Banner',
      'menu_name' => 'Categories Banners',
      'all_items' => 'All Categories Banners',
      'add_new_item' => 'Add New Categories Banners',
      'edit_item' => 'Edit Categories Banners'
    ],
    'public' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'thumbnail', 'custom-fields'],
  ]);
}
add_action('init', 'create_cate_banner_post_type');

function create_small_banners_post_type() {
  register_post_type('small_banners', [
    'labels' => [
      'name' => 'Small Banners',
      'singular_name' => 'Small Banner',
      'menu_name' => 'Small Banners',
      'all_items' => 'All Small Banners',
      'add_new_item' => 'Add New Small Banners',
      'edit_item' => 'Edit Small Banners'
    ],
    'public' => true,
    'show_in_rest' => true,
    'supports' => ['title', 'thumbnail', 'custom-fields'],
  ]);
}
add_action('init', 'create_small_banners_post_type');


/** ================== CUSTOM FIELD===================== */

/** CF Banner */
function register_banner_meta_fields() {
    register_post_meta('banner', 'image', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_post_meta('banner', 'link', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_post_meta('banner', 'title', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'register_banner_meta_fields');

/** CF Categories */
function register_cate_item_meta_fields() {
  register_post_meta('cate_post', 'short_desc', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);

  register_post_meta('cate_post', 'thumbnail', [
    'type' => 'string', // kiểu đường dẫn ảnh nên để string
    'single' => true,
    'show_in_rest' => true,
  ]);
}
add_action('init', 'register_cate_item_meta_fields');


/** CF Car Blog */
function register_carsblogs_item_meta_fields() {
  register_post_meta('cars_blog', 'blog_desc', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
}
add_action('init', 'register_carsblogs_item_meta_fields');


/** Custom Field cho post_item ===== */ 
function register_post_item_meta_fields() {
  register_post_meta('post_item', 'logo', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);

  register_post_meta('post_item', 'top', [
    'type' => 'number',
    'single' => true,
    'show_in_rest' => true,
  ]);

  register_post_meta('post_item', 'id_cate', [
    'type' => 'number',
    'single' => true,
    'show_in_rest' => true,
  ]);
    register_post_meta('post_item', 'image', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
   register_post_meta('post_item', 'desc', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
   register_post_meta('post_item', 'date', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
   register_post_meta('post_item', 'author', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
     register_post_meta('post_item', 'author_logo', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
}
add_action('init', 'register_post_item_meta_fields');



/* ===================relationship==================  */

function add_post_item_cate_metabox() {
    add_meta_box(
        'post_item_cate_box',        // ID của metabox
        'Select Category',           // Tiêu đề hiển thị
        'render_post_item_cate_box', // Callback để hiển thị nội dung
        'post_item',                 // CPT áp dụng
        'side',                      // Vị trí (side = cột bên phải)
        'default'
    );
}
add_action('add_meta_boxes', 'add_post_item_cate_metabox');

// Hiển thị dropdown category trong metabox
function render_post_item_cate_box($post) {
    $current_cate = get_post_meta($post->ID, 'id_cate', true);
    $categories = get_posts([
        'post_type' => 'cate_post',
        'numberposts' => -1,
        'post_status' => 'publish'
    ]);

    echo '<select name="id_cate" style="width:100%">';
    echo '<option value="">-- Select Category --</option>';
    foreach ($categories as $cate) {
        $selected = ($cate->ID == $current_cate) ? 'selected' : '';
        echo "<option value='{$cate->ID}' {$selected}>{$cate->post_title}</option>";
    }
    echo '</select>';
}

// Lưu lại meta id_cate khi update post_item
function save_post_item_cate_meta($post_id) {
    if (array_key_exists('id_cate', $_POST)) {
        update_post_meta($post_id, 'id_cate', intval($_POST['id_cate']));
    }
}
add_action('save_post_post_item', 'save_post_item_cate_meta');


/** BOX selected Cate Banner */


// 1️⃣ Tạo metabox để chọn Banner cho CPT small_banners
function add_banner_select_metabox_for_small_banners() {
    add_meta_box(
        'small_banner_box',           // ID duy nhất
        'Select Category Banner',     // Tiêu đề hiển thị
        'render_small_banner_box',    // Callback render
        'small_banners',              // Áp dụng cho CPT này
        'side',                       // Vị trí (sidebar)
        'default'                     // Mức ưu tiên
    );
}
add_action('add_meta_boxes', 'add_banner_select_metabox_for_small_banners');


// 2️⃣ Hàm render giao diện dropdown trong admin
function render_small_banner_box($post) {
    // Lấy giá trị banner hiện tại (nếu có)
    $current_banner = get_post_meta($post->ID, 'id_cate_banner', true);

    // Lấy tất cả banner từ CPT cate_banner
    $banners = get_posts([
        'post_type' => 'cate_banner',
        'numberposts' => -1,
        'post_status' => 'publish'
    ]);

    // Hiển thị dropdown
    echo '<label for="id_cate_banner">Choose a Category Banner:</label>';
    echo '<select name="id_cate_banner" id="id_cate_banner" style="width:100%;">';
    echo '<option value="">-- Select Banner --</option>';

    foreach ($banners as $banner) {
        $selected = ($banner->ID == $current_banner) ? 'selected' : '';
        echo "<option value='{$banner->ID}' {$selected}>{$banner->post_title}</option>";
    }

    echo '</select>';
}


// 3️⃣ Lưu giá trị khi nhấn “Update”
function save_small_banner_meta($post_id) {
    if (isset($_POST['id_cate_banner'])) {
        update_post_meta($post_id, 'id_cate_banner', sanitize_text_field($_POST['id_cate_banner']));
    }
}
add_action('save_post_small_banners', 'save_small_banner_meta');




