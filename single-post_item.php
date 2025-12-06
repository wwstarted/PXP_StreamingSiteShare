<?php get_header(); ?>
<div class="container">
    <div class="breadcrumb">

    </div>
    <!-- Breadcrumb -->
</div>

<div class="container">
    <div class="outline">
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
                <img src="https://images.unsplash.com/photo-1637335088701-d204113650f3?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c3RyZWFtaW5nJTIwc2l0ZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&q=60&w=600"
                    alt="Ad banner" />
            </div>

            <div class="comment-box">
                <input type="text" placeholder="Để lại bình luận..." />
                <a href="<?php echo home_url("/404notfound") ?>"><button>Gửi</button></a>
            </div>
        </div>
    </div>

    <section class="brand-section-de">
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
<?php get_footer() ?>