<?php get_header(); ?>
<div class="container">

    <div class="breadcrumb">
        <?php
        $sep = ' <span class="breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span> ';

        echo '<a href="' . home_url() . '"><i class="fa-solid fa-house"></i> Home</a>';

        if (is_category()) {
            echo $sep . '<span>' . single_cat_title('', false) . '</span>';
        }

        if (is_single()) {
            $categories = get_the_category();
            if (!empty($categories)) {
                $cat_link = get_category_link($categories[0]->term_id);
                echo $sep . '<a href="' . esc_url($cat_link) . '">' . esc_html($categories[0]->name) . '</a>';
            }
            echo $sep . '<span>' . get_the_title() . '</span>';
        }

        if (is_page() && !is_front_page()) {
            echo $sep . '<span>' . get_the_title() . '</span>';
        }
        ?>
    </div>


</div>

<div class="container">
    <!-- Banner Section -->
    <section class="banner" id="banner-section">
        <!-- fetch data here -->
    </section>


    <!--  Main Content Section -->
    <section class="content">
        <!-- Left Column -->
        <div class="right_content">
            <div id="right_content_top">
                <!-- fetch data here -->
            </div>

            <div id="right_content_bottom">
                <!-- fetch data here -->
            </div>
        </div>

        <!-- Right Column -->
        <div class="left_content">
            <h2>Related</h2>
            <!-- fetch data here -->
        </div>
    </section>

    <!--  Slider Section -->
    <!-- <section class="brand-section">
        <div class="brand-header">
            <h2 style="font-weight: 900">Our Posts</h2>
            <a href="#" class="show-all">SHOW ALL</a>
        </div>

        <div class="brand-slider">
            <button class="slide-btn prev-btn">&#10094;</button>

            <div class="brand-container" id="brand-container">
                
            </div>

            <button class="slide-btn next-btn">&#10095;</button>
        </div>
    </section> -->

    <section class="stats-insights-section">
        <div class="stats-header">
            <h2>Category Insights</h2>
            <p class="stats-subtitle">Discover the most popular posts in this category</p>
        </div>

        <div class="stats-grid">
            <!-- Total Posts Card -->
            <div class="stat-card total-card">
                <div class="stat-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" id="total-posts">0</h3>
                    <p class="stat-label">Total Posts</p>
                </div>
            </div>

            <!-- Average Popularity Card -->
            <div class="stat-card avg-card">
                <div class="stat-icon">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" id="avg-popularity">0%</h3>
                    <p class="stat-label">Avg Popularity</p>
                </div>
            </div>

            <!-- Trending Badge Card -->
            <div class="stat-card trending-card">
                <div class="stat-icon">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" id="trending-count">0</h3>
                    <p class="stat-label">Trending Posts</p>
                </div>
            </div>
        </div>

        <!-- Top 3 Podium -->
        <div class="podium-section">
            <h3 class="podium-title">🏆 Top 3 Most Popular</h3>
            <div class="podium-container" id="podium-container">
                <!-- Second Place -->
                <div class="podium-item second-place" data-rank="2">
                    <div class="podium-content">
                        <div class="podium-rank-badge">2</div>
                        <img src="" alt="" class="podium-logo">
                        <h4 class="podium-name"></h4>
                        <div class="podium-bar">
                            <div class="podium-fill"></div>
                        </div>
                        <span class="podium-percent"></span>
                    </div>
                    <div class="podium-base second">
                        <span class="medal">🥈</span>
                    </div>
                </div>

                <!-- First Place -->
                <div class="podium-item first-place" data-rank="1">
                    <div class="podium-content">
                        <div class="podium-rank-badge gold">1</div>
                        <img src="" alt="" class="podium-logo">
                        <h4 class="podium-name"></h4>
                        <div class="podium-bar">
                            <div class="podium-fill"></div>
                        </div>
                        <span class="podium-percent"></span>
                    </div>
                    <div class="podium-base first">
                        <span class="medal">🥇</span>
                    </div>
                </div>

                <!-- Third Place -->
                <div class="podium-item third-place" data-rank="3">
                    <div class="podium-content">
                        <div class="podium-rank-badge">3</div>
                        <img src="" alt="" class="podium-logo">
                        <h4 class="podium-name"></h4>
                        <div class="podium-bar">
                            <div class="podium-fill"></div>
                        </div>
                        <span class="podium-percent"></span>
                    </div>
                    <div class="podium-base third">
                        <span class="medal">🥉</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popularity Chart -->
        <div class="chart-section">
            <h3 class="chart-title">📊 Popularity Distribution</h3>
            <div class="chart-container" id="chart-container">
                <!-- Bars will be generated by JS -->
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>

<!-- Footer -->