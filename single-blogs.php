<?php get_header(); ?>
<!-- Breadcrumb -->
<div class="container">
    <div class="breadcrumb_blog">

    </div>
</div>

<main class="container">
    <div class="content-wrapper">
        <!-- Article -->
        <article class="article">
            <div class="article-header">
                <!--fetch date here-->
            </div>

            <div class="article-content" id="article-content">
                <!-- fetch data here-->
            </div>
        </article>

        <!-- Sidebar -->
        <aside class="sidebar-v2">
            <!-- Popular Posts Widget -->
            <div class="sidebar-widget-v2">
                <h3 class="widget-title-v2">TIN ĐỌC NHIỀU</h3>
                <div class="posts-container-v2">
                    <!-- JS sẽ render posts vào đây -->
                </div>
                <div class="see-more-posts-v2">
                    <a href="<?php echo home_url('/blog/') ?>">
                        Xem tất cả <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Ad Banner -->
            <div class="ad-banner-v2">
                <h3>SEO</h3>
                <p>YOU CAN BE HERE!</p>
                <a href="<?php echo home_url('/404notfound') ?>" class="primary-button-v2">Contact Us</a>
            </div>
        </aside>
    </div>
    <!-- Related Posts -->
    <section class="related-posts-rp">
        <div style="text-align: center">
            <h2 class="related-title-rp" style="
            display: inline-block;
            border-bottom: 2px solid #fff;
            width: 360px;
            padding-bottom: 4px;
        ">
                Các bài viết liên quan
            </h2>
        </div>
        <div class="blog-grid-rp">
            <!-- JS sẽ render blog cards vào đây -->
        </div>
    </section>
</main>

<!-- Footer -->
<?php get_footer(); ?>