<?php get_header() ?>

<!-- Breadcrumb -->
<div class="container">
    <div class="breadcrumb">
        <a href="<?php echo home_url() ?>"><i class="fa-solid fa-house"></i> Streaming Sites</a> /
        <a href="<?php echo home_url("/blog") ?>">Blog</a>
    </div>
</div>



<main class="container">
    <!-- Hero Section -->
    <section class="hero-section">
        <!-- fetch data here  -->
    </section>

    <!-- Blog Section -->
    <section class="blog-section">
        <!-- fetch data here-->
    </section>

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

<?php get_footer() ?>