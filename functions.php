<?php
function load_assets()
{
  wp_enqueue_style('font-icon', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css', array(), '1.0', 'all');

  wp_enqueue_style('font-text', '///fonts.googleapis.com', array(), '1.0', 'all');

  wp_enqueue_style('proxyflow-blog', get_template_directory_uri() . '/css/404_notfound.css', array(), filemtime(get_stylesheet_directory() . '/css/404_notfound.css'));
  wp_enqueue_style('proxyflow-searc', get_template_directory_uri() . '/css/search.css', array(), filemtime(get_stylesheet_directory() . '/css/search.css'));
  wp_enqueue_style('proxyflow-post', get_template_directory_uri() . '/css/blog_detail.css', array(), filemtime(get_stylesheet_directory() . '/css/blog_detail.css'));
  wp_enqueue_style('proxyflow-reviews', get_template_directory_uri() . '/css/blog.css', array(), filemtime(get_stylesheet_directory() . '/css/blog.css'));
  wp_enqueue_style('proxyflow-home', get_template_directory_uri() . '/css/home2.css', array(), filemtime(get_stylesheet_directory() . '/css/home2.css'));
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
// require_once get_theme_file_path('/inc/reviews.php');
// require_once get_theme_file_path('/inc/cate_status.php');
// require_once get_theme_file_path('/inc/cate_checkbox.php');
require_once get_theme_file_path('/inc/blog_metafield.php');
require_once get_theme_file_path('inc/metabox_posts.php');
require_once get_theme_file_path('inc/metabox_cate_posts.php');





/** ============= Register CPT ============== */
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
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'show_in_rest' => true,
    'rewrite' => array('slug' => 'blog-tag'),
  );

  register_taxonomy('blog_tag', 'blogs', $args);
}
add_action('init', 'create_blog_tags_taxonomy');



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