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
            <h2>Movies Listing Blog</h2>
        </div>
        <div class="blog-grid-home" id="section-blog-home">
            <!-- fetch data here -->
        </div>


        <div style="text-align: center; margin-top: 30px">
            <a href="<?php echo home_url("/blog") ?>" class="visit-btn-bl"><span>Go to Car Blog</span>
                <i style="font-size: 14px; margin-top: 4px; margin-left: 6px" class="fa-solid fa-chevron-right"></i></a>
        </div>
    </section>


    <!-- Info Section -->


    <!--     <div id="cars-blogs-home">
       
    </div> -->

    <section class="info-section">
        <div>
            <div class="info-header">
                <h2><?php echo get_the_title(); ?></h2>
                <div class="info-icons">
                    <span>🌟</span>
                    <span>🏆</span>
                </div>
            </div>
            <div class="info-content">
                <p>
                    <?php the_content(); ?>
                </p>
                <div class="fade-overlay"></div>
            </div>
            <div class="btn-container">
                <button class="show-more" onclick="toggleContent(this)">
                    <span class="text">Read More</span>
                    <span class="icon"><i class="fa-solid fa-angles-down"></i></span>
                </button>
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-left">
            <h2>Movies Listing</h2>
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
                On The Most Popular<br />Movies Listing
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