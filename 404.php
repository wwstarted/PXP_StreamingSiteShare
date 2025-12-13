<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | <?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <?php wp_head(); ?>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/404-style.css" />
</head>

<body class="error404">

    <?php get_header(); ?>

    <div class="error-404-wrapper">

        <div class="particles" id="particles"></div>

        <div class="error-404-content">
            <h1 class="error-code">404</h1>
            <h2 class="error-message">Oops! Page Not Found</h2>
            <p class="error-description">
                The page you're looking for doesn't exist or has been moved.
            </p>

            <form class="search-form-404" id="google-search-form">
                <input type="text" id="search-input" placeholder="Search on Google..." autocomplete="off" />
                <button type="submit" id="search-btn">
                    <i class="fa fa-search"></i>
                </button>
            </form>

            <a href="<?php echo home_url(); ?>" class="home-button">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>

            <div class="categories-divider">── Or Browse Categories ──</div>
            <div class="categories-grid" id="categories-container">
                <div class="loading-categories">Loading categories...</div>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>

    <script src="<?php echo get_template_directory_uri(); ?>/404.js"></script>
</body>

</html>