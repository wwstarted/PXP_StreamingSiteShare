<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php
    $is_post_item_detail = is_singular('post');

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
                            <?php if ($has_custom_logo): ?>
                            <!-- Logo từ Options Page -->
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>"
                                class="site-logo">
                            <span>Streaming Sites</span>
                            <?php else: ?>
                            <!-- Fallback: Logo mặc định -->
                            <div class="logo-icon">▶</div>
                            <span>Streaming Sites</span>
                            <?php endif; ?>
                        </a>
                    </div>

                    <!-- Desktop / Tablet Menu -->
                    <div class="header-menu">
                        <nav>
                            <ul>
                                <li><a href="<?php echo home_url(); ?>">HOME</a></li>
                                <li><a href="<?php echo home_url('/blogs'); ?>">BLOG</a></li>
                                <li><a href="<?php echo home_url('/404notfound'); ?>">404</a></li>
                            </ul>
                        </nav>
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
                    <span>Streaming Sites</span>
                    <?php else: ?>
                    <!-- Fallback: Logo mặc định -->
                    <div class="logo-icon">▶</div>
                    <span>Streaming Sites</span>
                    <?php endif; ?>
                </a>
            </div>
            <button class="close-menu" id="closeMenuBtn" aria-label="Close menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="mobile-nav">
            <ul id="mobileMenu">
                <li><a href="<?php echo home_url(); ?>">HOME</a></li>
                <li><a href="<?php echo home_url('/blog'); ?>">BLOG</a></li>
                <li><a href="<?php echo home_url('/404notfound'); ?>">404</a></li>
            </ul>
        </nav>
    </div>

    <!-- Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>