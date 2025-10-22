<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Streaming Page</title>

    <?php wp_head(); ?>
    <!-- <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="categores.css" /> -->
    <!-- <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    /> -->
  </head>
  <body class="page-categories">
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