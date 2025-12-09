<?php get_header() ?>

<main class="container">
    <!-- Hero Carousel -->
    <section class="hero-carousel">
        <div class="carousel-wrapper" id="banner-carousel">
            <!--  Fetch Data here -->
        </div>
    </section>

    <!-- Cards Grid -->
    <section class="cards-grid categories-container-home">
        <!--  Fetch Data here -->
    </section>

    <!-- Blog Section -->
    <section class="blog-section-home">
        <div class="blog-header">
            <div class="logo-icon">▶</div>
            <h2>Streaming Sites Blog</h2>
        </div>
        <div class="blog-grid-home" id="section-blog-home">
            <!-- fetch data here -->
        </div>
        <div style="text-align: center; margin-top: 30px">
            <a href="<?php echo home_url("/blog") ?>" class="visit-btn-bl">
                <span>Go to Blog</span>
                <i style="font-size: 14px; margin-top: 4px; margin-left: 6px" class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </section>

    <!-- Info Section / Cars Blogs -->
    <div id="cars-blogs-home">
        <section class="info-section">
            <div class="info-header">
                <h2>
                    <i class="fa-solid fa-circle-info"></i>
                    <?php echo get_the_title(); ?>
                </h2>
                <div class="info-icons">
                    <span>🌟</span>
                    <span>🏆</span>
                </div>
            </div>

            <!-- Content Wrapper -->
            <div class="info-content-wrapper">
                <div class="info-content-scrollable">
                    <?php the_content() ?>
                </div>

                <!-- Fade Overlay -->
                <div class="fade-overlay"></div>
            </div>

            <!-- Read More Button -->
            <div class="btn-container">
                <button class="show-more" onclick="toggleContent(this)">
                    <span class="text">Read Less</span>
                    <span class="icon">
                        <i class="fa-solid fa-angles-up"></i>
                    </span>
                </button>
            </div>
        </section>
    </div>

    <style>
    /* Info Section - Scrollable Content */
    .info-content-scrollable {
        font-size: 17px;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.9);
        max-height: 850px;
        /* Giới hạn chiều cao */
        overflow-y: auto;
        /* Luôn có scroll khi nội dung dài */
        margin-bottom: 20px;
    }

    /* Custom scrollbar đẹp */
    .info-content-scrollable::-webkit-scrollbar {
        width: 10px;
    }

    .info-content-scrollable::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        margin: 5px 0;
    }

    .info-content-scrollable::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        border: 2px solid rgba(30, 41, 82, 0.85);
    }

    .info-content-scrollable::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
    }

    /* Firefox scrollbar */
    .info-content-scrollable {
        scrollbar-width: thin;
        scrollbar-color: #667eea rgba(255, 255, 255, 0.05);
    }

    /* Icon trong header */
    .info-header h2 i {
        color: #667eea;
        margin-right: 8px;
        font-size: 28px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.6;
        }
    }

    /* Paragraph spacing */
    .info-content-scrollable p {
        margin-bottom: 15px;
    }

    .info-content-scrollable p:last-child {
        margin-bottom: 0;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .info-header h2 {
            font-size: 24px;
        }

        .info-header h2 i {
            font-size: 22px;
        }

        .info-content-scrollable::-webkit-scrollbar {
            width: 6px;
        }
    }
    </style>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-left">
            <h2>StreamingSites.com</h2>
            <div class="cta-title">Watch</div>
            <p>Reviews The Best Streaming Sites Of 2025.</p>
            <div class="cta-features">
                <div class="cta-feature">
                    <div class="cta-feature-icon">🎬</div>
                    <div class="cta-feature-text">Free Movies</div>
                </div>
                <div class="cta-feature">
                    <div class="cta-feature-icon">📺</div>
                    <div>Live TV</div>
                </div>
                <div class="cta-feature">
                    <div class="cta-feature-icon">🌐</div>
                    <div>Websites</div>
                </div>
            </div>
            <p style="margin-top: 30px; font-size: 18px; font-weight: bold">
                On The Most Popular<br />Streaming Sites
            </p>
            <p>
                All the top streaming sites are sorted by quality, virus-free, and
                100% safe.
            </p>
        </div>
        <div class="cta-right">
            <img src="https://plus.unsplash.com/premium_photo-1721225464894-46e7bb29e446?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8c3RyZWFtaW5nJTIwc2l0ZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&q=60&w=600"
                alt="" style="
              width: 100%;
              height: 100%;
              object-fit: cover;
              object-position: center;
            " />
        </div>
    </section>
</main>

<!-- Footer -->
<?php get_footer() ?>