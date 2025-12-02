<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Details Page</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/detail_cate.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/categories.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/home.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <script>
  const WP_HOME = "<?= home_url(); ?>";
</script>
  </head>
  </head>
  
  <body class="page-details">
    
    <!-- Header -->
    <div class="hero-wrapper" >
      <header>
        <div class="container">
          <div class="header-content">
            <div class="logo">
              <div class="logo-icon">▶</div>
              <span>Streaming Sites</span>
            </div>
            <nav>
              <ul id="mainMenu">
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

      <section class="top-content" id="top-content-section">
        <!-- <div class="top-content-logo">
          <img
            class="top-content-logo-img"
            src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/4c004542-3820-4fe8-aa1c-9846aaeee0e8_nowm_64.png"
            alt="FX Networks"
          />
        </div>
        <div class="site-info">
          <h2>FX Networks</h2>
          <a href="#">https://www.fxnetworks.com</a>
          <div class="stars">★★★★★</div>
        </div> -->
      </section>
    </div>
    <div class="container">
      <div class="breadcrumb">
        
      </div>
    <!-- Breadcrumb -->
    </div>

    <div class="container">
      <main>
        <div class="left-content" id="content-left">
                  <!-- fetch data-->
        </div>

        <div class="right-content">
          <div class="rating-box">
            <h3>Ratings & Reviews</h3>
            <div id="goodabad">
              <div class="likes">
                <h4>Likes</h4>
                <div class="comment">
                  <span class="icon">✔</span>
                  <p>Nội dung đa dạng và hấp dẫn!</p>
                </div>
                <div class="comment">
                  <span class="icon">✔</span>
                  <p>Tốc độ load nhanh, hình ảnh đẹp.</p>
                </div>
              </div>
            
              <div class="hates">
                <h4>Hates</h4>
                <div class="comment">
                  <span class="icon">✖</span>
                  <p>Có quá nhiều quảng cáo xen giữa video.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="ad-banner">
            <img src="https://images.unsplash.com/photo-1637335088701-d204113650f3?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c3RyZWFtaW5nJTIwc2l0ZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&q=60&w=600" alt="Ad banner" />
          </div>

          <div class="comment-box">
            <input type="text" placeholder="Để lại bình luận..." />
            <a href="<?php echo home_url("/404notfound") ?>"><button>Gửi</button></a>
          </div>
        </div>
      </main>

      <section class="brand-section">
        <div class="brand-header">
          <h2 style="font-weight: 900">Our Partners</h2>
          <a href="#" class="show-all">SHOW ALL</a>
        </div>

        <div class="brand-slider">
          <button class="slide-btn prev-btn">&#10094;</button>

          <div class="brand-container" id="details-container">
              <!-- fetch data here -->          
          </div>

          <button class="slide-btn next-btn">&#10095;</button>
        </div>
      </section>
    </div>

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
                    'theme_location' => 'footer-menu',
                    'container' => false,
                    'menu_class' => '',
                    'items_wrap' => '%3$s' // chỉ lấy <li>
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
  </body>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/detail_cate.js"></script>
</html>
