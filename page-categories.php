<?php get_header(); ?>
  <div class="container">
      <div class="breadcrumb">
        <a href="<?php echo home_url() ?>"><i class="fa-solid fa-house"></i> Streaming Sites</a> /
        <a href="<?php echo home_url("/categories") ?>">Category</a>
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
      <section class="brand-section">
        <div class="brand-header">
          <h2 style="font-weight: 900">Our Posts</h2>
          <a href="#" class="show-all">SHOW ALL</a>
        </div>

        <div class="brand-slider">
          <button class="slide-btn prev-btn">&#10094;</button>

          <div class="brand-container" id="brand-container">
              <!-- fetch data here -->          
          </div>

          <button class="slide-btn next-btn">&#10095;</button>
        </div>
      </section>
    </div>

    <?php get_footer(); ?>

    <!-- Footer -->

