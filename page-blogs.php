<?php get_header() ?>

<!-- ========================================
     BLOG ARCHIVE - MODERN MAGAZINE STYLE
     Complete HTML Structure
======================================== -->

<!-- Breadcrumb -->
<div class="container">
    <div class="breadcrumb">
        <a href="<?php echo home_url() ?>">
            <i class="fa-solid fa-house"></i> Home
        </a>
        <span>/</span>
        <span>Blog</span>
    </div>
</div>



<main class="container">

    <!-- ========================================
         HERO SLIDER SECTION
    ======================================== -->
    <section class="hero-slider-section">
        <!-- JS will render slider here -->
    </section>

    <!-- ========================================
         BLOG SECTION - TABS & GRID
    ======================================== -->
    <section class="blog-main-section">

        <!-- Controls: Search & Sort -->
        <div class="blog-controls">
            <div class="blog-search-sort">
                <div class="blog-search-wrapper">
                    <i class="fa-solid fa-search blog-search-icon"></i>
                    <input type="text" class="blog-search-input" placeholder="Search articles..." />
                </div>
                <select class="blog-sort-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="popular">Most Popular</option>
                </select>
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="blog-tabs-wrapper">
            <div class="blog-tabs">
                <!-- JS will render tabs here -->
            </div>
        </div>

        <!-- Blog Grid -->
        <div class="blog-grid-modern">
            <!-- JS will render blog cards here -->
        </div>

        <!-- Load More Button -->
        <div class="blog-load-more">
            <button class="load-more-btn">
                <span>Load More Articles</span>
                <i class="fa-solid fa-chevron-down"></i>
            </button>
        </div>
    </section>

    <!-- ========================================
         CTA SECTION - NEWSLETTER
    ======================================== -->
    <section class="cta-newsletter-section">
        <div class="cta-newsletter-content">
            <div class="cta-newsletter-icon">
                📧
            </div>
            <h2 class="cta-newsletter-title">Stay Updated!</h2>
            <p class="cta-newsletter-text">
                Subscribe to our newsletter and never miss the latest streaming site reviews,
                guides, and exclusive content delivered straight to your inbox.
            </p>
            <form class="cta-newsletter-form" action="<?php echo home_url('/404notfound') ?>" method="get">
                <input type="email" class="cta-newsletter-input" placeholder="Enter your email address" required />
                <button type="submit" class="cta-newsletter-btn">
                    Subscribe Now
                </button>
            </form>
            <div class="cta-newsletter-stats">
                <div class="cta-stat">
                    <span class="cta-stat-number">10K+</span>
                    <span class="cta-stat-label">Subscribers</span>
                </div>
                <div class="cta-stat">
                    <span class="cta-stat-number">500+</span>
                    <span class="cta-stat-label">Articles</span>
                </div>
                <div class="cta-stat">
                    <span class="cta-stat-number">50+</span>
                    <span class="cta-stat-label">Reviews</span>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer() ?>