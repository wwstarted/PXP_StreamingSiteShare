<?php
/**=================== Load ASSETS ====================== */

function load_assets()
{
  // Gọi Link CDN Font awesome
  wp_enqueue_style('font-icon', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css', array(), '1.0', 'all');

  // Gọi Link URL Font text
  wp_enqueue_style('font-text', '///fonts.googleapis.com', array(), '1.0', 'all');

  // Gọi thêm các file CSS con trong thư mục /css/
  wp_enqueue_style('proxyflow-blog', get_template_directory_uri() . '/css/404_notfound.css', array(), filemtime(get_stylesheet_directory() . '/css/404_notfound.css'));
  wp_enqueue_style('proxyflow-searc', get_template_directory_uri() . '/css/search.css', array(), filemtime(get_stylesheet_directory() . '/css/search.css'));
  wp_enqueue_style('proxyflow-post', get_template_directory_uri() . '/css/blog_detail.css', array(), filemtime(get_stylesheet_directory() . '/css/blog_detail.css'));
  wp_enqueue_style('proxyflow-reviews', get_template_directory_uri() . '/css/blog.css', array(), filemtime(get_stylesheet_directory() . '/css/blog.css'));
  wp_enqueue_style('proxyflow-home', get_template_directory_uri() . '/css/home.css', array(), filemtime(get_stylesheet_directory() . '/css/home.css'));
  wp_enqueue_style('proxyflow-style', get_template_directory_uri() . '/css/categories.css', array(), filemtime(get_stylesheet_directory() . '/css/categories.css'));
  wp_enqueue_style('wpadmin-style', get_template_directory_uri() . '/css/detail_cate.css', array(), filemtime(get_stylesheet_directory() . '/css/detail_cate.css'));
  wp_enqueue_style('wpadmin-style1', get_template_directory_uri() . '/css/style.css', array(), filemtime(get_stylesheet_directory() . '/css/style.css'));
  // Gọi file JS trong thư mục /js/
  wp_enqueue_script('proxyflow-blog', get_template_directory_uri() . '/js/404.js', array('jquery'), filemtime(get_template_directory() . '/js/404.js'), true);
  wp_enqueue_script('proxyflow-post', get_template_directory_uri() . '/js/blogs.js', array('jquery'), filemtime(get_template_directory() . '/js/blogs.js'), true);
  wp_enqueue_script('proxyflow-home', get_template_directory_uri() . '/js/categores.js', array('jquery'), filemtime(get_template_directory() . '/js/categores.js'), true);
  wp_enqueue_script('proxyflow-oxylabs', get_template_directory_uri() . '/js/detail_cate.js', array('jquery'), filemtime(get_template_directory() . '/js/detail_cate.js'), true);
  wp_enqueue_script('proxyflow-blog1', get_template_directory_uri() . '/js/details_blog.js', array('jquery'), filemtime(get_template_directory() . '/js/details_blog.js'), true);
  wp_enqueue_script('proxyflow-blog2', get_template_directory_uri() . '/js/header.js', array('jquery'), filemtime(get_template_directory() . '/js/header.js'), true);
  wp_enqueue_script('proxyflow-blog3', get_template_directory_uri() . '/js/home.js', array('jquery'), filemtime(get_template_directory() . '/js/home.js'), true);
  wp_enqueue_script('proxyflow-search', get_template_directory_uri() . '/js/search.js', array(), filemtime(get_template_directory() . '/js/search.js'), true);

}
add_action('wp_enqueue_scripts', 'load_assets');

require_once get_theme_file_path('/inc/uploads.php');
require_once get_theme_file_path('/inc/logo.php');
require_once get_theme_file_path('/inc/reviews.php');




/** ============= Register CPT ============== */

/** CPT BANNER */
function create_banner_cpt()
{
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


/** CPT BLOGS */

function create_blogs_cpt()
{
  $labels = array(
    'name' => 'Blogs',
    'singular_name' => 'Blog',
    'menu_name' => 'Blogs',
    'all_items' => 'All Blogs',
    'add_new_item' => 'Add New Blog',
    'edit_item' => 'Edit Blog'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'has_archive' => false,
    'menu_position' => 20,
    'menu_icon' => 'dashicons-images-alt2',
    'supports' => array('title', 'thumbnail', 'custom-fields'),
    'show_in_rest' => true
  );
  register_post_type('blogs', $args);
}
add_action('init', 'create_blogs_cpt');


/** Metabox DESC BLOG */
function add_blog_desc_metabox()
{
  add_meta_box(
    'blog_desc_box',             // ID
    'Blog Description',          // Tiêu đề box
    'render_blog_desc_metabox',  // Callback render nội dung
    'blogs',                     // CPT bạn muốn thêm
    'normal',                    // Vị trí
    'high'                       // Ưu tiên
  );
}
add_action('add_meta_boxes', 'add_blog_desc_metabox');


// Hàm hiển thị trình soạn thảo
function render_blog_desc_metabox($post)
{
  // Lấy dữ liệu đã lưu (nếu có)
  $desc = get_post_meta($post->ID, '_blog_desc', true);

  // Sử dụng trình soạn thảo TinyMCE có toolbar đầy đủ
  wp_editor(
    $desc, // nội dung đã lưu
    'blog_desc', // tên field
    array(
      'textarea_name' => 'blog_desc',
      'media_buttons' => true, // cho phép chèn ảnh
      'textarea_rows' => 10,
      'teeny' => false, // false = hiển thị đầy đủ toolbar
      'quicktags' => true, // cho phép dùng HTML nhanh
    )
  );
}


// Lưu dữ liệu khi update/publish bài viết
function save_blog_desc_metabox($post_id)
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;
  if (isset($_POST['blog_desc'])) {
    update_post_meta($post_id, '_blog_desc', wp_kses_post($_POST['blog_desc']));
  }
}
add_action('save_post', 'save_blog_desc_metabox');


/** CPT Categories Blog */


// Đăng ký taxonomy cho Blogs
function create_blog_category_taxonomy()
{
  $labels = array(
    'name' => 'Blog Categories',
    'singular_name' => 'Blog Category',
    'menu_name' => 'Categories',
    'all_items' => 'All Categories',
    'edit_item' => 'Edit Category',
    'update_item' => 'Update Category',
    'add_new_item' => 'Add New Category',
    'new_item_name' => 'New Category Name',
    'search_items' => 'Search Categories',
    'popular_items' => 'Popular Categories',
    'separate_items_with_commas' => 'Separate categories with commas',
    'add_or_remove_items' => 'Add or remove categories',
    'choose_from_most_used' => 'Choose from the most used categories',
    'not_found' => 'No categories found.'
  );

  $args = array(
    'labels' => $labels,
    'hierarchical' => true, // true = dạng checkbox tree như Category
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_rest' => true, // quan trọng: để REST API hoạt động
    'rewrite' => array('slug' => 'blog-category'),
  );

  register_taxonomy('blog_category', array('blogs'), $args);
}
add_action('init', 'create_blog_category_taxonomy');

// Register taxonomy Blog Tags cho CPT blogs
function create_blog_tags_taxonomy()
{
  $labels = array(
    'name' => 'Blog Tags',
    'singular_name' => 'Blog Tag',
    'search_items' => 'Search Blog Tags',
    'popular_items' => 'Popular Blog Tags',
    'all_items' => 'All Blog Tags',
    'edit_item' => 'Edit Blog Tag',
    'update_item' => 'Update Blog Tag',
    'add_new_item' => 'Add New Blog Tag',
    'new_item_name' => 'New Blog Tag Name',
    'separate_items_with_commas' => 'Separate tags with commas',
    'add_or_remove_items' => 'Add or remove tags',
    'choose_from_most_used' => 'Choose from the most used tags',
    'menu_name' => 'Tags',
  );

  $args = array(
    'hierarchical' => false, // false = kiểu tag, true = kiểu category
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'show_in_rest' => true, // Quan trọng để hiển thị trong Gutenberg + REST API
    'rewrite' => array('slug' => 'blog-tag'),
  );

  register_taxonomy('blog_tag', 'blogs', $args);
}
add_action('init', 'create_blog_tags_taxonomy');


function create_cate_post_type()
{
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
    'has_archive' => true,
    'rewrite' => [
      'slug' => 'reviews',
      'with_front' => false
    ],
  ]);
}
add_action('init', 'create_cate_post_type');

/** CPT POST */
function create_post_item_type()
{
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
    'rewrite' => [
      'slug' => 'info',
      'with_front' => false
    ],
  ]);
}
add_action('init', 'create_post_item_type');


/** CPT Car Blog */
function create_cars_blogs_item_type()
{
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

function create_small_banners_post_type()
{
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
function register_small_banner_meta_fields()
{
  // Ảnh
  register_post_meta('small_banners', 'sbanner_image', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);

  // Link
  register_post_meta('small_banners', 'sbanner_link', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);

  // ID category (array)
  register_post_meta('small_banners', 'id_cate_post', [
    'type' => 'array',
    'single' => true,
    'show_in_rest' => [
      'schema' => [
        'type' => 'array',
        'items' => [
          'type' => 'integer',
        ],
      ],
    ],
  ]);
}
add_action('init', 'register_small_banner_meta_fields');


function register_banner_meta_fields()
{
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
function register_cate_item_meta_fields()
{
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


/** CF Blogs */
function register_blogs_meta_fields()
{
  register_post_meta('blogs', 'bg_short_desc', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);

  register_post_meta('blogs', '_blog_desc', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);

  register_post_meta('blogs', 'bg_thumbnail', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
  register_post_meta('blogs', 'bg_author', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
  register_post_meta('blogs', 'bg_date', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
  register_post_meta('blogs', 'bg_avatar', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
  register_post_meta('blogs', 'bg_author_logo', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
}
add_action('init', 'register_blogs_meta_fields');



/** CF Car Blog */
function register_carsblogs_item_meta_fields()
{
  register_post_meta('cars_blog', 'blog_desc', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
}
add_action('init', 'register_carsblogs_item_meta_fields');


/** Custom Field cho post_item ===== */
function register_post_item_meta_fields()
{
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
  register_post_meta('post_item', 'popularity', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
  register_post_meta('post_item', 'post_link', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
  register_post_meta('post_item', 'likes', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
  register_post_meta('post_item', 'hates', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
  register_post_meta('post_item', 'bgr_image', [
    'type' => 'string',
    'single' => true,
    'show_in_rest' => true,
  ]);
}
add_action('init', 'register_post_item_meta_fields');



/* ===================relationship==================  */

function add_post_item_cate_metabox()
{
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
function render_post_item_cate_box($post)
{
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
function save_post_item_cate_meta($post_id)
{
  if (array_key_exists('id_cate', $_POST)) {
    update_post_meta($post_id, 'id_cate', intval($_POST['id_cate']));
  }
}
add_action('save_post_post_item', 'save_post_item_cate_meta');


/** BOX selected Cate Banner */
function add_multi_category_metabox_for_small_banners()
{
  add_meta_box(
    'small_banner_multi_cate_box',
    'Select Categories',
    'render_small_banner_multi_cate_box',
    'small_banners',
    'side',
    'default'
  );
}
add_action('add_meta_boxes', 'add_multi_category_metabox_for_small_banners');

function render_small_banner_multi_cate_box($post)
{
  // Lấy danh sách category hiện tại (array hoặc rỗng)
  $current_cates = get_post_meta($post->ID, 'id_cate_post', true);
  if (!is_array($current_cates)) {
    $current_cates = [];
  }

  // Lấy tất cả category từ CPT cate_post
  $categories = get_posts([
    'post_type' => 'cate_post',
    'numberposts' => -1,
    'post_status' => 'publish'
  ]);

  echo '<p><strong>Assign this banner to categories:</strong></p>';
  echo '<div style="max-height:180px; overflow-y:auto; border:1px solid #ccc; padding:8px; border-radius:6px;">';

  foreach ($categories as $cate) {
    $checked = in_array($cate->ID, $current_cates) ? 'checked' : '';
    echo '
            <label style="display:block; margin-bottom:4px;">
                <input type="checkbox" name="id_cate_post[]" value="' . esc_attr($cate->ID) . '" ' . $checked . '>
                ' . esc_html($cate->post_title) . '
            </label>
        ';
  }

  echo '</div>';
}


// 3️⃣ Lưu danh sách category khi update post
function save_small_banner_multi_cate_meta($post_id)
{
  // Bảo vệ tránh autosave
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;

  // Kiểm tra quyền người dùng
  if (!current_user_can('edit_post', $post_id))
    return;

  // Xử lý checkbox
  if (isset($_POST['id_cate_post'])) {
    $selected_cates = array_map('intval', (array) $_POST['id_cate_post']);
    update_post_meta($post_id, 'id_cate_post', $selected_cates);
  } else {
    delete_post_meta($post_id, 'id_cate_post');
  }
}
add_action('save_post_small_banners', 'save_small_banner_multi_cate_meta');

function filter_features_group_rest_query($args, $request)
{

  if (isset($request['meta_key']) && isset($request['meta_value'])) {
    $args['meta_query'] = [
      [
        'key' => sanitize_text_field($request['meta_key']),
        'value' => sanitize_text_field($request['meta_value']),
      ]
    ];
  }

  return $args;
}
add_filter('rest_features_group_query', 'filter_features_group_rest_query', 10, 2);