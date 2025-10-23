<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Streaming Sites - Home</title>
    <!-- <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="home.css" /> -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/home.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
  </head>
  <body>
    <!-- Header -->
    <header>
      <div class="container">
        <div class="header-content">
          <div class="logo">
            <div class="logo-icon">▶</div>
            <span>Streaming Sites</span>
          </div>
          <nav>
            <ul id="footerMenu">
            <?php
              wp_nav_menu(array(
                  'theme_location' => 'primary-menu',
                  'container' => false,
                  'menu_class' => 'main-menu',
                  'items_wrap' => '<ul id="mainMenu">%3$s</ul>'
              ));
            ?>
            </ul>
          </nav>
          <div class="search-box">
            <div class="input-search-icon">
              <input
                type="text"
                placeholder="Stream your next favorite thing..."
              />
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

    <main class="container">
      <!-- Hero Carousel -->
      <section class="hero-carousel">
        <div class="carousel-wrapper" id="banner-carousel">
               <!--  Fetch Data here -->
        </div>
      </section>

      <!-- Cards Grid -->
      <section class="cards-grid categories-container">
              <!--  Fetch Data here -->
      </section>

      <!-- Banner Section -->
      <section class="banner-section">
        <i
          class="banner-section-icon banner-section-prev fa-solid fa-chevron-left"
        ></i>
        <div class="banner-section-slide" id="banner-slide">
            <!-- fetch data  -->
        </div>
          <i
            class="banner-section-icon banner-section-back fa-solid fa-chevron-right"
          ></i>
      </section>

      <!-- Info Section -->
       
      
      <div id="cars-blogs">
            <!-- fetch data  -->
      </div>

      <!-- Blog Section -->
      <section class="blog-section">
        <div class="blog-header">
          <div class="logo-icon">▶</div>
          <h2>Streaming Sites Blog</h2>
        </div>
        <div class="blog-grid" id="section-blog">
               <!-- fetch data here -->
        </div>
        <div style="text-align: right; margin-top: 30px">
          <a href="./blog.html" class="visit-btn"
            ><span>Go to Blog</span>
            <i style="font-size: 10px" class="fa-solid fa-chevron-right"></i
          ></a>
        </div>
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
          <img
            src="https://plus.unsplash.com/premium_photo-1721225464894-46e7bb29e446?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8c3RyZWFtaW5nJTIwc2l0ZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&q=60&w=600"
            alt=""
            style="
              width: 100%;
              height: 100%;
              object-fit: cover;
              object-position: center;
            "
          />
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="footer-content">
          <div class="footer-content-top">
            <div class="logo">
              <div class="logo-icon">▶</div>
              <span>Streaming Sites</span>
            </div>
            <div class="social-icons">
              <span><i class="fa-brands fa-square-facebook"></i></span>
              <span><i class="fa-brands fa-youtube"></i></span>
              <span><i class="fa-brands fa-x-twitter"></i></span>
            </div>
          </div>
          <div class="footer-content-main">
            <nav>
              <ul id="footerMenu">
                <?php
                  wp_nav_menu(array(
                      'theme_location' => 'primary-menu',
                      'container' => false,
                      'menu_class' => 'main-menu',
                      'items_wrap' => '<ul id="mainMenu">%3$s</ul>'
                  ));
                ?>
            </ul>
            </nav>
          </div>
          <div class="footer-content-end">
            © 2019 - 2025 StreamingSites.com - The Best Streaming Sites
          </div>
        </div>
      </div>
    </footer>

    <!-- Import file JS -->
    <!-- <script src="./home.js"></script> -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/home.js"></script>
  </body>
</html>
