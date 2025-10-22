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
    <?php wp_footer(); ?>
  </body>
  <!-- <script src="./categores.js"></script> -->
</html>