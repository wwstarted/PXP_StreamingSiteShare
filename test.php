<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Streaming Page</title>
    <?php wp_head(); ?>
</head>

<body class="page-categories">
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <div class="logo-icon">▶</div>
                    <span>Streaming Sites</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="header-menu">
                    <nav>
                        <ul style="padding-left: 115px; padding-right: 15px;">
                            <li><a href="<?php echo home_url(); ?>">HOME</a></li>
                            <li><a href="<?php echo home_url('/blog'); ?>">BLOG</a></li>
                            <li><a href="<?php echo home_url('/404notfound'); ?>">404</a></li>
                        </ul>
                    </nav>
                </div>

                <!-- Search Box (Desktop & iPad) -->
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
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Drawer -->
    <div class="mobile-menu-drawer" id="mobileDrawer">
        <div class="mobile-menu-header">
            <div class="logo">
                <div class="logo-icon">▶</div>
                <span>Streaming Sites</span>
            </div>
            <button class="close-menu" id="closeMenuBtn" aria-label="Close menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="mobile-menu-header">
            <div class="logo">
                <div class="logo-icon">▶</div>
                <span>StreamingSite</span>
            </div>
            <button class="close-menu" id="closeMenuBtn" aria-label="Close Menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="mobile-nav">
            <ul id="mobileMenu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary-menu',
                    'container' => false,
                    'items_wrap' => '%3$s'
                ));
                ?>
            </ul>
        </nav>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>