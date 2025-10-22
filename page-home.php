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
            <!-- <ul id="mainMenu">
              <li><a href="/index.html">Home</a></li>
              <li class="has-dropdown">
                <a href="#pages">
                  Pages
                  <i class="icon-down-menu fa-solid fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="#about">About</a></li>
                  <li><a href="./categores.html">Categores</a></li>
                  <li><a href="#team">Team</a></li>
                  <li><a href="#contact">Contact</a></li>
                </ul>
              </li>
              <li><a href="/blog.html">Blog</a></li>
            </ul> -->

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
        <div class="carousel-wrapper">
          <div class="carousel-item">
            <img
              class="carousel-image"
              src="https://images.unsplash.com/photo-1585378335564-c220f04a9ad0?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fHN0cmVhbWluZyUyMHNpdGVzfGVufDB8fDB8fHww&auto=format&fit=crop&q=60&w=600"
              alt="baner image"
            />
            <button class="btn carousel-btn">
              Get Planet VPN
              <i class="carousel-btn-icon fa-solid fa-angles-right"></i>
            </button>
          </div>
          <div class="carousel-item">
            <img
              class="carousel-image"
              src="https://images.unsplash.com/photo-1585378335564-c220f04a9ad0?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fHN0cmVhbWluZyUyMHNpdGVzfGVufDB8fDB8fHww&auto=format&fit=crop&q=60&w=600"
              alt="baner image"
            />
            <button class="btn carousel-btn">
              Get Planet VPN
              <i class="carousel-btn-icon fa-solid fa-angles-right"></i>
            </button>
          </div>
          <div class="carousel-item">
            <img
              class="carousel-image"
              src="https://images.unsplash.com/photo-1585378335564-c220f04a9ad0?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fHN0cmVhbWluZyUyMHNpdGVzfGVufDB8fDB8fHww&auto=format&fit=crop&q=60&w=600"
              alt="baner image"
            />
            <button class="btn carousel-btn">
              Get Planet VPN
              <i class="carousel-btn-icon fa-solid fa-angles-right"></i>
            </button>
          </div>
          <div class="carousel-item">
            <img
              class="carousel-image"
              src="https://images.unsplash.com/photo-1585378335564-c220f04a9ad0?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fHN0cmVhbWluZyUyMHNpdGVzfGVufDB8fDB8fHww&auto=format&fit=crop&q=60&w=600"
              alt="baner image"
            />
            <button class="btn carousel-btn">
              Get Planet VPN
              <i class="carousel-btn-icon fa-solid fa-angles-right"></i>
            </button>
          </div>
        </div>
      </section>

      <!-- Cards Grid -->
      <section class="cards-grid">
        <div class="card">
          <div class="card-header">
            <div class="card-icon">
              <img
                class="card-icon-image"
                src="https://plus.unsplash.com/premium_photo-1676901712447-4395959ac6cf?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=880"
                alt="icon box"
              />
            </div>
            <div class="text-line card-title">
              <a
                class="card-title-link"
                href="http://127.0.0.1:5500/categores.html"
                >Best Movie Streaming Sites</a
              >
              <div class="card-tag">
                <span class="catrd-tag-cate">Streaming Sites</span>
              </div>
            </div>
          </div>
          <p class="text-line card-description">
            I used to download all the movies I wanted to watch during the
            holidays, but I'm happy to say finding movies and TV has become a
            lot easier over the years.
          </p>
          <ul class="features-list">
            <li>
              <p class="features-list-top">1</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="text-line features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">2</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">3</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">4</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">5</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">6</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">7</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">8</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">9</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">10</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
          </ul>
          <div class="card-footer">
            <a href="#" class="visit-btn"
              >View all <i class="fa-solid fa-chevron-right"></i
            ></a>
            <div class="arrow-icon">
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-icon">
              <img
                class="card-icon-image"
                src="https://plus.unsplash.com/premium_photo-1676901712447-4395959ac6cf?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=880"
                alt="icon box"
              />
            </div>
            <div class="text-line card-title">
              <a
                class="card-title-link"
                href="http://127.0.0.1:5500/categores.html"
                >Best Movie Streaming Sites</a
              >
              <div class="card-tag">
                <span class="catrd-tag-cate">Streaming Sites</span>
              </div>
            </div>
          </div>
          <p class="text-line card-description">
            I used to download all the movies I wanted to watch during the
            holidays, but I'm happy to say finding movies and TV has become a
            lot easier over the years.
          </p>
          <ul class="features-list">
            <li>
              <p class="features-list-top">1</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="text-line features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">2</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">3</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">4</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">5</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">6</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">7</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">8</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">9</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">10</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
          </ul>
          <div class="card-footer">
            <a href="#" class="visit-btn"
              >View all <i class="fa-solid fa-chevron-right"></i
            ></a>
            <div class="arrow-icon">
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-icon">
              <img
                class="card-icon-image"
                src="https://plus.unsplash.com/premium_photo-1676901712447-4395959ac6cf?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=880"
                alt="icon box"
              />
            </div>
            <div class="text-line card-title">
              <a
                class="card-title-link"
                href="http://127.0.0.1:5500/categores.html"
                >Best Movie Streaming Sites</a
              >
              <div class="card-tag">
                <span class="catrd-tag-cate">Streaming Sites</span>
              </div>
            </div>
          </div>
          <p class="text-line card-description">
            I used to download all the movies I wanted to watch during the
            holidays, but I'm happy to say finding movies and TV has become a
            lot easier over the years.
          </p>
          <ul class="features-list">
            <li>
              <p class="features-list-top">1</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="text-line features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">2</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">3</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">4</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">5</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">6</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">7</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">8</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">9</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">10</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
          </ul>
          <div class="card-footer">
            <a href="#" class="visit-btn"
              >View all <i class="fa-solid fa-chevron-right"></i
            ></a>
            <div class="arrow-icon">
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-icon">
              <img
                class="card-icon-image"
                src="https://plus.unsplash.com/premium_photo-1676901712447-4395959ac6cf?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=880"
                alt="icon box"
              />
            </div>
            <div class="text-line card-title">
              <a
                class="card-title-link"
                href="http://127.0.0.1:5500/categores.html"
                >Best Movie Streaming Sites</a
              >
              <div class="card-tag">
                <span class="catrd-tag-cate">Streaming Sites</span>
              </div>
            </div>
          </div>
          <p class="text-line card-description">
            I used to download all the movies I wanted to watch during the
            holidays, but I'm happy to say finding movies and TV has become a
            lot easier over the years.
          </p>
          <ul class="features-list">
            <li>
              <p class="features-list-top">1</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="text-line features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">2</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">3</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">4</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">5</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">6</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">7</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">8</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">9</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">10</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
          </ul>
          <div class="card-footer">
            <a href="#" class="visit-btn"
              >View all <i class="fa-solid fa-chevron-right"></i
            ></a>
            <div class="arrow-icon">
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-icon">
              <img
                class="card-icon-image"
                src="https://plus.unsplash.com/premium_photo-1676901712447-4395959ac6cf?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=880"
                alt="icon box"
              />
            </div>
            <div class="text-line card-title">
              <a
                class="card-title-link"
                href="http://127.0.0.1:5500/categores.html"
                >Best Movie Streaming Sites</a
              >
              <div class="card-tag">
                <span class="catrd-tag-cate">Streaming Sites</span>
              </div>
            </div>
          </div>
          <p class="text-line card-description">
            I used to download all the movies I wanted to watch during the
            holidays, but I'm happy to say finding movies and TV has become a
            lot easier over the years.
          </p>
          <ul class="features-list">
            <li>
              <p class="features-list-top">1</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="text-line features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">2</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">3</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">4</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">5</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">6</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">7</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">8</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">9</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">10</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
          </ul>
          <div class="card-footer">
            <a href="#" class="visit-btn"
              >View all <i class="fa-solid fa-chevron-right"></i
            ></a>
            <div class="arrow-icon">
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-icon">
              <img
                class="card-icon-image"
                src="https://plus.unsplash.com/premium_photo-1676901712447-4395959ac6cf?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=880"
                alt="icon box"
              />
            </div>
            <div class="text-line card-title">
              <a
                class="card-title-link"
                href="http://127.0.0.1:5500/categores.html"
                >Best Movie Streaming Sites</a
              >
              <div class="card-tag">
                <span class="catrd-tag-cate">Streaming Sites</span>
              </div>
            </div>
          </div>
          <p class="text-line card-description">
            I used to download all the movies I wanted to watch during the
            holidays, but I'm happy to say finding movies and TV has become a
            lot easier over the years.
          </p>
          <ul class="features-list">
            <li>
              <p class="features-list-top">1</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="text-line features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">2</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">3</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">4</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">5</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">6</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">7</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">8</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">9</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
            <li>
              <p class="features-list-top">10</p>
              <img
                class="features-list-logo-image"
                src="https://web.archive.org/web/20250826173531if_/https://static.streamingsites.com/9111c332-1838-4de8-a948-e7efb342bd64_nowm_48.png"
                alt="logo provider"
              />
              <p class="features-list-name">menace king</p>
            </li>
          </ul>
          <div class="card-footer">
            <a href="#" class="visit-btn"
              >View all <i class="fa-solid fa-chevron-right"></i
            ></a>
            <div class="arrow-icon">
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
              <img
                class="arrow-icon-logo"
                src="https://web.archive.org/web/20250730004137/https://static.streamingsites.com/e5a0d444-5d6b-4677-b5f9-16b098abb3fd_nowm_32.png"
                alt="logo provider"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Banner Section -->
      <section class="banner-section">
        <i
          class="banner-section-icon banner-section-prev fa-solid fa-chevron-left"
        ></i>
        <div class="banner-section-slide">
          <div class="banner-card">
            <img
              src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&h=250&fit=crop"
              alt="YouTube"
              class="banner-card-image"
            />
            <div class="banner-card-btn">Xem Thêm</div>
          </div>
          <div class="banner-card">
            <img
              src="https://images.unsplash.com/photo-1611605698335-8b1569810432?w=400&h=250&fit=crop"
              alt="Instagram"
              class="banner-card-image"
            />
            <div class="banner-card-btn">Khám Phá</div>
          </div>
          <div class="banner-card">
            <img
              src="https://images.unsplash.com/photo-1611926653458-09294b3142bf?w=400&h=250&fit=crop"
              alt="TikTok"
              class="banner-card-image"
            />
            <div class="banner-card-btn">Tìm Hiểu</div>
          </div>
          <div class="banner-card">
            <img
              src="https://images.unsplash.com/photo-1611605698323-b1e99cfd37ea?w=400&h=250&fit=crop"
              alt="Twitter"
              class="banner-card-image"
            />
            <div class="banner-card-btn">Theo Dõi</div>
          </div>
          <div class="banner-card">
            <img
              src="https://images.unsplash.com/photo-1611944212129-29977ae1398c?w=400&h=250&fit=crop"
              alt="LinkedIn"
              class="banner-card-image"
            />
            <div class="banner-card-btn">Kết Nối</div>
          </div>
        </div>
        <i
          class="banner-section-icon banner-section-back fa-solid fa-chevron-right"
        ></i>
      </section>

      <!-- Info Section -->
      <section class="info-section">
        <div class="info-header">
          <h2>Streaming Sites</h2>
          <div class="info-icons">
            <span>🌟</span>
            <span>🏆</span>
          </div>
        </div>
        <div class="info-content">
          <p class="info-content-tiltle">
            With so many different streaming sites out there nowadays, choosing
            the right one can be a tough decision.
          </p>
          <p>
            With so many different streaming sites out there nowadays, choosing
            the right one can be a tough decision. With so many of the best TV
            and streaming sites bringing new subscribers in thanks of new
            blockbuster releases and of course, its pricing fee – which can
            range from free to hundreds of dollars a year. When it comes time to
            make our next stream platform choice, there are so few things we had
            to pay attention.
          </p>
          <p>
            Content library is one of the most important factors. Each platform
            offers different shows, movies, and exclusive originals. Consider
            what type of content you enjoy most and which service provides the
            best selection in that category.
          </p>
          <p>
            Video quality and streaming performance also matter significantly.
            Most services now offer 4K content, but the streaming quality can
            vary based on your internet connection and the platform's
            infrastructure.
          </p>
          <div class="fade-overlay"></div>
        </div>
        <div class="btn-container">
          <button class="show-more" onclick="toggleContent(this)">
            <span class="text">Read More</span>
            <span class="icon"><i class="fa-solid fa-angles-down"></i></span>
          </button>
        </div>
      </section>

      <section class="info-section">
        <div class="info-header">
          <h2>What is Streaming?</h2>
          <div class="info-icons">
            <span>🤨</span>
            <span>🧐</span>
          </div>
        </div>
        <div class="info-content">
          <p class="info-content-tiltle">
            Streaming has quickly become the most popular and widely used way
            for people to access their favorite movies and TV series.
          </p>
          <p>
            Sure, we have all heard the term used before – most frequently in
            reference to services like Netflix, Hulu, and Amazon Prime Video –
            but what does it actually mean? How does streaming actually work?
          </p>
          <p>
            Well, to put it most basically, streaming is the constant
            transmission of video or audio content from the main server to a
            viewer. When you stream all movies from, say, Amazon Prime, then,
            the movie or
          </p>
          <p>
            Video quality and streaming performance also matter significantly.
            Most services now offer 4K content, but the streaming quality can
            vary based on your internet connection and the platform's
            infrastructure.
          </p>
          <div class="fade-overlay"></div>
        </div>
        <div class="btn-container">
          <button class="show-more" onclick="toggleContent(this)">
            <span class="text">Read More</span>
            <span class="icon"><i class="fa-solid fa-angles-down"></i></span>
          </button>
        </div>
      </section>

      <section class="info-section">
        <div class="info-header">
          <h2>Why did I make StreamingSites.com?</h2>
          <div class="info-icons">
            <span>🤖</span>
            <span>👾</span>
            <span>🎮</span>
            <span>👨🏻‍💻</span>
          </div>
        </div>
        <div class="info-content">
          <p class="info-content-tiltle">
            I made this site for a few reasons. Firstly, I am passionate about
            movies and television.
          </p>
          <p>
            At StreamingSites, I believe that everyone deserves to find whatever
            TV shows or movies that they are looking for, regardless of how much
            money someone makes or how tech-savvy a person happens to be. I want
            to help create a thriving culture of streamers that never have to go
            without seeing their favorite TV shows, events, games, cartoons, or
            artists. I believe that open and abundant access to media helps to
            enhance us culturally.
          </p>
          <p>
            Content library is one of the most important factors. Each platform
            offers different shows, movies, and exclusive originals. Consider
            what type of content you enjoy most and which service provides the
            best selection in that category.
          </p>
          <p>
            Video quality and streaming performance also matter significantly.
            Most services now offer 4K content, but the streaming quality can
            vary based on your internet connection and the platform's
            infrastructure.
          </p>
          <div class="fade-overlay"></div>
        </div>
        <div class="btn-container">
          <button class="show-more" onclick="toggleContent(this)">
            <span class="text">Read More</span>
            <span class="icon"><i class="fa-solid fa-angles-down"></i></span>
          </button>
        </div>
      </section>

      <!-- Blog Section -->
      <section class="blog-section">
        <div class="blog-header">
          <div class="logo-icon">▶</div>
          <h2>Streaming Sites Blog</h2>
        </div>
        <div class="blog-grid">
          <div class="blog-card">
            <div class="blog-image">📺</div>
            <div class="blog-content">
              <h3 class="text-line blog-title">
                FSMS Sites: What is it? Exam Material & Importance FSMS Sites:
                What is it? Exam Material & Importance
              </h3>
              <p class="text-line blog-description">
                Code sites help project managers standardize development
                processes and ensure quality. The process of using these codes
                involves testing all features to ensure they work properly.
                involves testing all features to ensure they work properly.
              </p>
              <div class="blog-meta">
                <img
                  class="blog-meta-avatar"
                  src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=764"
                  alt=""
                />
                <span>FSM Sites | 21.04.2025</span>
              </div>
              <a href="#" class="read-more"
                ><span>Read more</span>
                <i style="font-size: 10px" class="fa-solid fa-chevron-right"></i
              ></a>
            </div>
          </div>

          <div class="blog-card">
            <div
              class="blog-image"
              style="background: linear-gradient(135deg, #f093fb, #f5576c)"
            >
              🎮
            </div>
            <div class="blog-content">
              <h3 class="text-line blog-title">FAMUSINGS</h3>
              <p class="text-line blog-description">
                Unreal Streaming: A Gamers Streaming Service Or Experience.
                Unreal streaming also helps improve speed quality videos and
                photos.
              </p>
              <div class="blog-meta">
                <img
                  class="blog-meta-avatar"
                  src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=764"
                  alt=""
                />
                <span>FSM Sites | 21.04.2025</span>
              </div>
              <a href="#" class="read-more"
                ><span>Read more</span>
                <i style="font-size: 10px" class="fa-solid fa-chevron-right"></i
              ></a>
            </div>
          </div>

          <div class="blog-card">
            <div
              class="blog-image"
              style="background: linear-gradient(135deg, #4facfe, #00f2fe)"
            >
              🎯
            </div>
            <div class="blog-content">
              <h3 class="text-line blog-title">
                Unreal Streaming: A Gamers Paradise On Gaming Platform
              </h3>
              <p class="text-line blog-description">
                Discover how digital footprint improves efficiency and
                interaction between organizations. We explain what digital means
                on internet.
              </p>
              <div class="blog-meta">
                <img
                  class="blog-meta-avatar"
                  src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=764"
                  alt=""
                />
                <span>FSM Sites | 21.04.2025</span>
              </div>
              <a href="#" class="read-more"
                ><span>Read more</span>
                <i style="font-size: 10px" class="fa-solid fa-chevron-right"></i
              ></a>
            </div>
          </div>
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
