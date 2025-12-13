<footer>
    <div class="container">
        <div class="footer-content">

            <!-- TOP AREA - giữ nguyên -->
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

            <!-- FOOTER GRID – mới -->
            <div class="footer-grid">

                <!-- COLUMN 1 – giữ menu hiện tại -->
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul id="footerMenu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-menu',
                            'container' => false,
                            'menu_class' => '',
                            'items_wrap' => '%3$s'
                        ));
                        ?>
                    </ul>
                </div>

                <!-- COLUMN 2 – Popular Categories (auto WP) -->
                <div class="footer-col">
                    <h3>Popular Categories</h3>
                    <ul>
                        <?php
                        $popular_cates = get_categories(array(
                            'orderby' => 'count',
                            'order' => 'DESC',
                            'number' => 5,
                            'exclude' => get_cat_ID('chua-phan-loai')
                        ));
                        foreach ($popular_cates as $cate) {
                            echo '<li><a href="' . get_category_link($cate->term_id) . '">' . $cate->name . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <!-- COLUMN 3 – Resources -->
                <div class="footer-col">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="<?= home_url('/privacy-policy'); ?>">Privacy Policy</a></li>
                        <li><a href="<?= home_url('/terms-of-use'); ?>">Terms of Use</a></li>
                        <li><a href="<?= home_url('/dmca'); ?>">DMCA</a></li>
                        <li><a href="<?= home_url('/affiliate-disclosure'); ?>">Affiliate Disclosure</a></li>
                    </ul>
                </div>

                <!-- COLUMN 4 – Newsletter -->
                <div class="footer-col newsletter">
                    <h3>Stay Updated</h3>
                    <p>Subscribe to get weekly updates on top streaming sites.</p>

                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required />
                        <button type="submit">Subscribe</button>
                    </form>
                </div>

            </div>

            <!-- MID INFO BAR -->
            <div class="footer-mid-info">
                ✔ 2000+ streaming sites reviewed
                &nbsp;•&nbsp; Updated weekly
                &nbsp;•&nbsp; Zero ads, zero trackers
            </div>

            <!-- BOTTOM -->
            <div class="footer-content-end">
                © 2019 - 2025 StreamingSites.com - The Best Streaming Sites
            </div>

        </div>
    </div>
</footer>

<?php wp_footer(); ?>
<script>
const WP_HOME = "<?= home_url(); ?>";
</script>
</body>

</html>