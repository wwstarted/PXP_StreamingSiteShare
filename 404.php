<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | <?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <?php wp_head(); ?>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body.error404 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        padding: 20px;
    }

    /* Animated Background Particles */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 15s infinite ease-in-out;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            transform: translateY(-1000px) rotate(720deg);
            opacity: 0;
        }
    }

    /* Main Content Container */
    .page-404-container {
        position: relative;
        z-index: 10;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        max-width: 1000px;
        width: 100%;
    }

    /* 404 Title */
    .error-code {
        font-size: 140px;
        font-weight: 900;
        color: #fff;
        text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        margin: 0;
        line-height: 1;
        animation: glitch 3s infinite;
    }

    @keyframes glitch {

        0%,
        100% {
            transform: translate(0);
        }

        20% {
            transform: translate(-2px, 2px);
        }

        40% {
            transform: translate(-2px, -2px);
        }

        60% {
            transform: translate(2px, 2px);
        }

        80% {
            transform: translate(2px, -2px);
        }
    }

    .error-message {
        font-size: 28px;
        color: #fff;
        margin: 15px 0 20px;
        font-weight: 600;
    }

    .error-description {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 30px;
        max-width: 500px;
    }

    /* Search Form */
    .search-form-404 {
        display: flex;
        max-width: 450px;
        width: 100%;
        margin: 0 auto 20px;
        background: #fff;
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .search-form-404:focus-within {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .search-form-404 input {
        flex: 1;
        border: none;
        padding: 16px 24px;
        font-size: 15px;
        outline: none;
        background: transparent;
    }

    .search-form-404 input::placeholder {
        color: #999;
    }

    .search-form-404 button {
        padding: 16px 28px;
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
        color: #fff;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .search-form-404 button:hover {
        background: linear-gradient(45deg, #5568d3, #6a3f91);
    }

    /* Home Button */
    .home-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 35px;
        background: rgba(255, 255, 255, 0.95);
        color: #667eea;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        margin-bottom: 16px;
    }

    .home-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        background: #fff;
    }

    /* Categories Section */
    .categories-divider {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
        margin: 0 0 25px;
        font-weight: 500;
        letter-spacing: 1px;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 11px;
        max-width: 700px;
        width: 100%;
        padding-bottom: 80px;
    }

    .category-card-horizontal {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .category-card-horizontal:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .category-thumbnail-circle {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        background: linear-gradient(135deg, #667eea, #764ba2);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .category-thumbnail-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-thumbnail-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 900;
        color: #fff;
        text-transform: uppercase;
    }

    .category-info {
        flex: 1;
        text-align: left;
    }

    .category-name-horizontal {
        font-size: 14px;
        font-weight: 700;
        color: #333;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .category-posts-count {
        font-size: 11px;
        color: #777;
        font-weight: 500;
    }

    .category-arrow {
        font-size: 18px;
        color: #667eea;
        transition: transform 0.3s ease;
    }

    .category-card-horizontal:hover .category-arrow {
        transform: translateX(5px);
    }

    /* Bottom Logo */
    .bottom-logo {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 100;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .bottom-logo:hover {
        opacity: 1;
    }

    .bottom-logo a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50px;
        text-decoration: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .bottom-logo a:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .bottom-logo img {
        height: 30px;
        width: auto;
        object-fit: contain;
    }

    .bottom-logo-icon {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
        font-weight: bold;
    }

    .bottom-logo span {
        color: #333;
        font-size: 14px;
        font-weight: 700;
    }

    /* Loading State */
    .loading-categories {
        grid-column: 1 / -1;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        padding: 20px;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        body.error404 {
            padding: 15px;
        }

        .error-code {
            font-size: 80px;
        }

        .error-message {
            font-size: 22px;
            margin: 12px 0 15px;
        }

        .error-description {
            font-size: 14px;
            margin-bottom: 25px;
        }

        .search-form-404 {
            max-width: 100%;
            margin-bottom: 18px;
        }

        .search-form-404 input {
            padding: 14px 20px;
            font-size: 14px;
        }

        .search-form-404 button {
            padding: 14px 24px;
            font-size: 16px;
        }

        .home-button {
            padding: 12px 28px;
            font-size: 15px;
            margin-bottom: 18px;
        }

        .categories-divider {
            font-size: 13px;
            margin-bottom: 20px;
        }

        .categories-grid {
            grid-template-columns: 1fr;
            gap: 12px;
            padding-bottom: 80px;
        }

        .category-card-horizontal {
            padding: 12px 15px;
        }

        .category-thumbnail-circle {
            width: 60px;
            height: 60px;
        }

        .category-thumbnail-fallback {
            font-size: 28px;
        }

        .category-name-horizontal {
            font-size: 15px;
        }

        .category-posts-count {
            font-size: 12px;
        }

        .category-arrow {
            font-size: 16px;
        }

        .bottom-logo {
            bottom: 15px;
            right: 15px;
        }

        .bottom-logo img {
            height: 25px;
        }

        .bottom-logo-icon {
            width: 25px;
            height: 25px;
            font-size: 15px;
        }

        .bottom-logo span {
            font-size: 13px;
        }
    }

    @media (max-width: 480px) {
        .error-code {
            font-size: 60px;
        }

        .error-message {
            font-size: 18px;
        }

        .error-description {
            font-size: 13px;
        }

        .categories-divider {
            font-size: 12px;
        }

        .category-card-horizontal {
            padding: 10px 12px;
            gap: 12px;
        }

        .category-thumbnail-circle {
            width: 55px;
            height: 55px;
        }

        .category-name-horizontal {
            font-size: 14px;
        }
    }
    </style>
</head>

<body class="error404">
    <!-- Background Particles -->
    <div class="particles" id="particles"></div>

    <!-- Main Content -->
    <div class="page-404-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Oops! Page Not Found</h2>
        <p class="error-description">
            The page you're looking for doesn't exist or has been moved.
        </p>

        <!-- Google Search Form -->
        <form class="search-form-404" id="google-search-form">
            <input type="text" id="search-input" placeholder="Search on Google..." autocomplete="off" />
            <button type="submit" id="search-btn">
                <i class="fa fa-search"></i>
            </button>
        </form>

        <!-- Home Button -->
        <a href="<?php echo home_url(); ?>" class="home-button">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>

        <!-- Categories Section -->
        <div class="categories-divider">── Or Browse Categories ──</div>
        <div class="categories-grid" id="categories-container">
            <div class="loading-categories">Loading categories...</div>
        </div>
    </div>

    <!-- Bottom Right Logo -->
    <div class="bottom-logo">
        <?php
        $logo_url = get_option('site_logo_url', '');
        $has_custom_logo = !empty($logo_url);
        $site_name = get_bloginfo('name');
        ?>
        <a href="<?php echo home_url(); ?>">
            <?php if ($has_custom_logo): ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($site_name); ?>">
            <?php else: ?>
            <div class="bottom-logo-icon">▶</div>
            <?php endif; ?>
            <span><?php echo esc_html($site_name); ?></span>
        </a>
    </div>

    <script>
    // ========== Background Particles Animation ==========
    const particlesContainer = document.getElementById('particles');
    for (let i = 0; i < 30; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.width = Math.random() * 100 + 50 + 'px';
        particle.style.height = particle.style.width;
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 15 + 's';
        particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
        particlesContainer.appendChild(particle);
    }

    // ========== Google Search Form ==========
    const searchForm = document.getElementById('google-search-form');
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');

    function handleSearch(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        if (query) {
            const googleURL = `https://www.google.com/search?q=${encodeURIComponent(query)}`;
            window.open(googleURL, '_blank');
            searchInput.value = '';
        }
    }

    searchForm.addEventListener('submit', handleSearch);
    searchBtn.addEventListener('click', handleSearch);

    // ========== Fetch & Render Categories ==========
    async function renderCategories() {
        const container = document.getElementById('categories-container');

        try {
            // Fetch categories and posts in parallel
            const [categoriesRes, postsRes] = await Promise.all([
                fetch('http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/categories?per_page=100'),
                fetch('http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/posts?per_page=100')
            ]);

            const allCategories = await categoriesRes.json();
            const allPosts = await postsRes.json();

            // Filter visible categories
            const visibleCategories = allCategories.filter(cate => {
                const visible = cate.meta?._cate_visible;
                return visible === '1' || visible === 1 || visible === true;
            });

            // Take first 4 categories
            const categoriesToShow = visibleCategories.slice(0, 4);

            // Clear loading text
            container.innerHTML = '';

            if (categoriesToShow.length === 0) {
                container.innerHTML = '<div class="loading-categories">No categories available</div>';
                return;
            }

            // Render each category
            categoriesToShow.forEach((cate, index) => {
                const thumbnail = cate.meta?.thumbnail || '';
                const name = cate.name || 'Untitled';
                const link = cate.link || '#';
                const firstLetter = name.charAt(0).toUpperCase();

                // Count posts in this category
                const postsCount = allPosts.filter(post => {
                    const cats = post.categories || [];
                    return cats.includes(cate.id);
                }).length;

                const postsText = postsCount === 1 ? '1 site available' : `${postsCount} sites available`;

                const categoryCard = document.createElement('a');
                categoryCard.className = 'category-card-horizontal';
                categoryCard.href = link;
                categoryCard.style.opacity = '0';
                categoryCard.style.transform = 'translateY(20px)';

                categoryCard.innerHTML = `
                        <div class="category-thumbnail-circle">
                            ${thumbnail
                            ? `<img src="${thumbnail}" alt="${name}" />`
                            : `<div class="category-thumbnail-fallback">${firstLetter}</div>`
                        }
                        </div>
                        <div class="category-info">
                            <div class="category-name-horizontal">${name}</div>
                            <div class="category-posts-count">${postsText}</div>
                        </div>
                        <div class="category-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    `;

                container.appendChild(categoryCard);

                // Stagger animation
                setTimeout(() => {
                    categoryCard.style.transition = 'all 0.5s ease';
                    categoryCard.style.opacity = '1';
                    categoryCard.style.transform = 'translateY(0)';
                }, 100 * (index + 1));
            });

        } catch (error) {
            console.error('Error fetching categories:', error);
            container.innerHTML = '<div class="loading-categories">Failed to load categories</div>';
        }
    }

    // Load categories when page is ready
    document.addEventListener('DOMContentLoaded', renderCategories);
    </script>

    <?php wp_footer(); ?>
</body>

</html>