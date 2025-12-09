<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php
    $is_post_item_detail = is_singular('post_item');

    $logo_url = get_option('site_logo_url', '');
    $has_custom_logo = !empty($logo_url);
    ?>

    <?php if ($is_post_item_detail): ?>
    <div class="hero-wrapper">
        <?php endif; ?>

        <header>
            <div class="container">
                <div class="header-content">

                    <!-- Logo -->
                    <div class="logo">
                        <a href="<?php echo home_url(); ?>">

                            <?php
                            $logo_url = get_theme_mod('header_logo');
                            $site_title = get_bloginfo('name');
                            ?>

                            <?php if ($logo_url): ?>

                            <!-- Có logo → hiện logo, không hiện chữ -->
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($site_title); ?>"
                                class="site-logo">

                            <?php else: ?>

                            <!-- Không có logo → hiện fallback icon + chữ -->
                            <div class="logo-icon">▶</div>
                            <span><?php echo esc_html($site_title); ?></span>

                            <?php endif; ?>

                        </a>
                    </div>

                    <!-- Desktop / Tablet Menu -->
                    <div class="header-menu">
                        <?php if (has_nav_menu('main-menu')): ?>
                        <nav class="main-nav">
                            <?php
                                wp_nav_menu([
                                    'theme_location' => 'main-menu',
                                    'container' => false,
                                    'menu_class' => 'main-menu-list'
                                ]);
                                ?>
                        </nav>
                        <?php endif; ?>
                    </div>

                    <!-- Search + Social -->
                    <div class="search-box">
                        <div class="input-search-icon">
                            <input type="text" placeholder="Stream your next favorite thing..." />
                            <i class="icon-search fa-solid fa-magnifying-glass"></i>
                        </div>

                        <div class="social-icons">
                            <span><i class="fa-brands fa-square-facebook"></i></span>
                            <span><i class="fa-brands fa-youtube"></i></span>
                            <span><i class="fa-brands fa-x-twitter"></i></span>
                        </div>

                        <!-- Mobile Hamburger -->
                        <button id="openMenuBtn" class="hamburger">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <?php if ($is_post_item_detail): ?>
        <section class="top-content" id="top-content-section">
        </section>
        <?php endif; ?>

        <?php if ($is_post_item_detail): ?>
    </div>
    <!-- End Hero Wrapper -->
    <?php endif; ?>

    <!-- Mobile Menu Drawer -->
    <div class="mobile-menu-drawer" id="mobileDrawer">
        <div class="mobile-menu-header">
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <?php if ($has_custom_logo): ?>
                    <!-- Logo từ Options Page -->
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" class="site-logo">
                    <span>Movies Listing</span>
                    <?php else: ?>
                    <!-- Fallback: Logo mặc định -->
                    <div class="logo-icon">▶</div>
                    <span>Movies Listing</span>
                    <?php endif; ?>
                </a>
            </div>
            <button class="close-menu" id="closeMenuBtn" aria-label="Close menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="mobile-nav">
            <ul id="mobileMenu">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',   // lấy Main Menu luôn
                    'container' => false,
                    'menu_id' => 'mobileMenu',
                    'menu_class' => 'mobile-menu-list'
                ]);
                ?>
            </ul>
        </nav>
    </div>

    <!-- Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>