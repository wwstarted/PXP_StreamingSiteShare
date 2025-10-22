<?php

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
        get_theme_file_uri('/css/categores.css'),
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


/* REST API & fetch DATA*/
// Register Banner CPT
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

