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

            <!-- 1. USER REVIEWS SECTION -->
            <div class="user-reviews-section">
                <h3>User Reviews</h3>

                <!-- Review Card 1 -->
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">JD</div>
                        <div class="review-info">
                            <p class="review-name">John Doe</p>
                            <div class="review-rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                        </div>
                    </div>
                    <p class="review-text">
                        Amazing streaming quality! The interface is super smooth and content library is huge. Definitely
                        worth it!
                    </p>
                </div>

                <!-- Review Card 2 -->
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">SM</div>
                        <div class="review-info">
                            <p class="review-name">Sarah Miller</p>
                            <div class="review-rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star empty">★</span>
                            </div>
                        </div>
                    </div>
                    <p class="review-text">
                        Great service overall. Fast loading times and good selection. Only issue is occasional buffering
                        during peak hours.
                    </p>
                </div>

                <!-- Review Card 3 -->
                <!-- <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">MJ</div>
                        <div class="review-info">
                            <p class="review-name">Mike Johnson</p>
                            <div class="review-rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                        </div>
                    </div>
                    <p class="review-text">
                        Best streaming platform I've used! Clean UI, no ads, and excellent customer support. Highly
                        recommend!
                    </p>
                </div> -->

                <!-- Review Card 4 -->
                <!-- <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar">EW</div>
                        <div class="review-info">
                            <p class="review-name">Emily Wilson</p>
                            <div class="review-rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star empty">★</span>
                            </div>
                        </div>
                    </div>
                    <p class="review-text">
                        Solid platform with great features. Works perfectly on all my devices. Would give 5 stars if
                        they had more international content.
                    </p>
                </div> -->
            </div>

            <!-- 2. AD BANNER - REDESIGNED -->
            <div class="ad-banner">
                <img src="https://tse4.mm.bing.net/th/id/OIP.GnITgT3eFRmwzqyVn4zUagHaDp?pid=Api&P=0&h=220"
                    alt="Ad banner" />
            </div>

            <!-- 3. COMMENT BOX - PREMIUM REDESIGN -->
            <div class="comment-box">
                <h4>Leave a Review</h4>

                <!-- Star Rating Picker -->
                <div class="star-rating-picker">
                    <label>Your Rating:</label>
                    <div class="stars-input" id="starsInput">
                        <button type="button" class="star-btn" data-rating="1">★</button>
                        <button type="button" class="star-btn" data-rating="2">★</button>
                        <button type="button" class="star-btn" data-rating="3">★</button>
                        <button type="button" class="star-btn" data-rating="4">★</button>
                        <button type="button" class="star-btn" data-rating="5">★</button>
                    </div>
                </div>

                <!-- Textarea -->
                <textarea id="commentTextarea" placeholder="Share your experience with this streaming service..."
                    maxlength="500"></textarea>

                <!-- Submit Button -->
                <a href="<?php echo home_url('/404notfound') ?>" class="btn-submit" id="submitBtn">
                    Submit Review
                </a>
            </div>

        </div>
    </div>

    <section class="detail-related-section">
        <div class="detail-related-header">
            <h2 style="font-weight: 900">Similar Streaming Sites</h2>
            <!-- Optional: Add "SHOW ALL" link if needed -->
            <!-- <a href="<?php echo home_url('/categories/') ?>" class="show-all-detail">SHOW ALL</a> -->
        </div>

        <div class="detail-related-slider">
            <button class="detail-slider-btn detail-prev-btn">&#10094;</button>

            <div class="detail-cards-wrapper" id="details-container">
                <!-- JS will render detail-stream-card here -->
            </div>

            <button class="detail-slider-btn detail-next-btn">&#10095;</button>
        </div>
    </section>

</div>
<?php get_footer() ?>