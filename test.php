<?php get_header(); ?>
<div class="container">
    <div class="breadcrumb">

    </div>
    <!-- Breadcrumb -->
</div>

<!-- ✅ THÊM CLASS MỚI detail-page-container -->
<div class="container detail-page-container">
    <div class="outline">
        <div class="left-content" id="content-left">
            <!-- fetch data-->
        </div>

        <div class="right-content">

            <!-- 1. USER REVIEWS SECTION -->
            <div class="user-reviews-section" id="goodabad">
                <!-- JS will render reviews here -->
            </div>

            <!-- 2. PREMIUM AD BANNER -->
            <a href="<?php echo home_url('/your-ad-link') ?>" class="premium-ad-banner">
                <div class="premium-ad-content">
                    <!-- Shine Effect -->
                    <div class="premium-ad-shine"></div>

                    <!-- Image Section -->
                    <div class="premium-ad-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=800&h=400&fit=crop"
                            alt="Premium Service">
                        <div class="premium-ad-overlay"></div>
                        <span class="premium-ad-label">Sponsored</span>
                    </div>

                    <!-- Info Section -->
                    <div class="premium-ad-info">
                        <h3 class="premium-ad-title">Premium Streaming Service</h3>
                        <p class="premium-ad-description">
                            Experience unlimited entertainment with 4K quality and no ads. Start your free trial today!
                        </p>
                        <span class="premium-ad-cta">
                            Learn More
                            <span class="premium-ad-cta-icon">→</span>
                        </span>
                    </div>
                </div>
            </a>

            <!-- 3. COMMENT BOX - PREMIUM REDESIGN -->
            <div class="comment-box">
                <!-- JS will render comment form here -->
            </div>

        </div>
    </div>

    <section class="detail-related-section">
        <div class="detail-related-header">
            <h2 style="font-weight: 900">Similar Streaming Sites</h2>
            <!-- Optional: Add "SHOW ALL" link if needed -->
            <!-- <a href="<?php echo home_url('/categories/') ?>" class="show-all-detail">SHOW ALL</a> -->
        </div>

        <div class="detail-related-slider">
            <button class="detail-slider-btn detail-prev-btn">&#10094;</button>

            <div class="detail-cards-wrapper" id="details-container">
                <!-- JS will render detail-stream-card here -->
            </div>

            <button class="detail-slider-btn detail-next-btn">&#10095;</button>
        </div>
    </section>

</div>
<?php get_footer() ?>