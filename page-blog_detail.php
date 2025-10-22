<?php get_header(); ?>
    <!-- Breadcrumb -->
    <div class="container">
      <div class="breadcrumb">
        <a href="#"><i class="fa-solid fa-house"></i> Streaming Sites</a> /
        <a href="#">Blog</a> /
        <span>Hướng dẫn cài đặt wordpress trên server xampp</span>
      </div>
    </div>

    <main class="container">
      <div class="content-wrapper">
        <!-- Article -->
        <article class="article">
          <div class="article-header">
            <div class="article-tags">
              <span class="tag">Giải trí</span>
              <span class="tag">Tin tức</span>
            </div>
            <h1>Hướng dẫn cài đặt WORDPRESS trên SERVERXAMPP</h1>
            <div class="article-meta">
              <div class="article-meta-left">
                <span class="article-views">
                  <i class="fa-solid fa-eye"></i>
                  46 lượt xem
                </span>
                <div class="author">
                  <img src="https://i.pravatar.cc/150?img=1" alt="Author" />
                  <span>Nate Wick — 2 jul 2025</span>
                </div>
              </div>
              <div class="article-actions">
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-linkedin"></i>
              </div>
            </div>
          </div>

          <div class="article-content">
            <p>
              Cài đặt một tài khoản cho wordpress trên MYSQL XAMPP. Trong phần
              này chúng ta sẽ chạy MYSQL và ra phần Administration để thực hiện.
            </p>

            <p>
              Chạy tên tức thư trước là cài MYSQL XAMPP cũng phải có sẵn và chạy
              PHP lúc bấy giờ nhé. Mình sẽ trực tiếp qua phần login với giao
              diện PhpMyAdmin. Các bạn cũng có thể thực hiện như mình nhé, vì
              đây là những bước mà mọi người đều phải sử dụng khi triển khai một
              trang web WordPress.
            </p>

            <p>
              Đừng lo lắng, mình sẽ giải thích rõ ràng từng bước và lưu ý các
              vấn đề thường gặp khi cài đặt WordPress trên XAMPP, giúp các bạn
              có thể hoàn thành quá trình này một cách dễ dàng.
            </p>

            <!-- Table of Contents -->
            <div class="table-of-contents">
              <div class="toc-header" onclick="toggleTOC()">
                <h3><i class="fa-solid fa-list-ul"></i> Nội dung chính</h3>
                <i
                  class="fa-solid fa-chevron-down toc-toggle"
                  id="tocToggle"
                ></i>
              </div>
              <div class="toc-content" id="tocContent">
                <ul class="toc-list">
                  <li>
                    <a href="#step1">
                      <span class="toc-number">1.</span>
                      <span
                        >Tải xuống và cài đặt WORDPRESS trên SERVER XAMPP</span
                      >
                    </a>
                  </li>
                  <li>
                    <a href="#step2">
                      <span class="toc-number">2.</span>
                      <span>Tạo Cơ sở dữ liệu WordPress</span>
                    </a>
                  </li>
                  <li>
                    <a href="#step3">
                      <span class="toc-number">3.</span>
                      <span>Cấu hình file wp-config.php</span>
                    </a>
                  </li>
                  <li>
                    <a href="#step4">
                      <span class="toc-number">4.</span>
                      <span>Hoàn tất cài đặt WordPress</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>

            <h2 id="step1">
              Bước 1: Tải xuống và cài đặt WORDPRESS trên SERVER XAMPP
            </h2>

            <p>
              Đầu tiên các bạn vào trang http://wordpress.org và nhấp vào nút
              tải về WordPress. Sau khi tải xuống, bạn cần giải nén thư mục tải
              xuống để nhận được thư mục có tên là wordpress.
            </p>

            <img
              src="https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=800&q=80"
              alt="WordPress Download"
            />

            <p>
              Sau đó bạn cần đổi tên thư mục để có tên gọi là wordpress2. Sau
              khi hoàn tất, các bạn cần di chuyển thư mục này đến nơi có thể
              chạy trên máy chủ.
            </p>

            <h2 id="step2">Bước 2: Tạo Cơ sở dữ liệu WordPress</h2>

            <p>
              Để wordpress có thể chạy được, bạn cần tạo một cơ sở dữ liệu cho
              nó. Các bước thực hiện như sau:
            </p>

            <img
              src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80"
              alt="Database Setup"
            />

            <ul>
              <li>Mở XAMPP Control Panel và khởi động Apache và MySQL</li>
              <li>Truy cập vào http://localhost/phpmyadmin</li>
              <li>
                Tạo một database mới với tên bạn mong muốn (ví dụ: wordpress_db)
              </li>
              <li>Lưu lại tên database để sử dụng trong quá trình cài đặt</li>
            </ul>

            <img
              src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80"
              alt="Database Configuration"
            />

            <p>
              Khi đã tạo xong cơ sở dữ liệu, các bạn có thể bắt đầu quá trình
              cài đặt WordPress. Truy cập vào http://localhost/wordpress trong
              trình duyệt để bắt đầu cài đặt.
            </p>

            <h2 id="step3">Bước 3: Cấu hình file wp-config.php</h2>

            <p>
              Trong bước này, bạn cần cấu hình file wp-config.php để kết nối
              WordPress với database vừa tạo. Điền đầy đủ thông tin database
              name, username và password.
            </p>

            <img
              src="https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&q=80"
              alt="WordPress Installation"
            />

            <h2 id="step4">Bước 4: Hoàn tất cài đặt WordPress</h2>

            <p>
              Sau khi hoàn tất các bước trên, bạn có thể đăng nhập vào trang
              quản trị WordPress và bắt đầu xây dựng website của mình.
            </p>

            <h2>Lời kết</h2>

            <p>
              Như vậy là chúng ta đã hoàn thành các bước cài đặt WordPress trên
              XAMPP một cách đơn giản và dễ dàng. Hy vọng bài viết này sẽ giúp
              ích cho những ai đang muốn tìm hiểu và thực hành với WordPress
              trên môi trường local.
            </p>

            <p>
              Nếu gặp bất kỳ khó khăn nào trong quá trình cài đặt, các bạn có
              thể để lại comment bên dưới, mình sẽ cố gắng hỗ trợ sớm nhất có
              thể. Chúc các bạn thành công!
            </p>
          </div>
        </article>

        <!-- Sidebar -->
        <aside class="sidebar">
          <!-- Popular Posts -->
          <div class="sidebar-widget">
            <h3>TIN ĐỌC NHIỀU</h3>
            <div class="post-item">
              <div class="post-thumbnail">
                <img
                  src="https://images.unsplash.com/photo-1522542550221-31fd19575a2d?w=200&q=80"
                  alt="Post"
                />
              </div>
              <div class="post-info">
                <h4>
                  <a class="text-line text-blog-tilte" href="#"
                    >Vì sao Mạnh Hùng - ông chú Toàn Shinbi vẫn chưa lấy vợ?</a
                  >
                </h4>
                <div class="post-date">
                  <i class="fa-regular fa-clock"></i> 8 Jul 2025
                </div>
              </div>
            </div>
            <div class="post-item">
              <div class="post-thumbnail">
                <img
                  src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=200&q=80"
                  alt="Post"
                />
              </div>
              <div class="post-info">
                <h4>
                  <a class="text-line text-blog-tilte" href="#"
                    >Từ địa ngục nước mắt xua Đông Nhi lột xác Thành Nữ hoàng
                    Vpop</a
                  >
                </h4>
                <div class="post-date">
                  <i class="fa-regular fa-clock"></i> 7 Jul 2025
                </div>
              </div>
            </div>
            <div class="post-item">
              <div class="post-thumbnail">
                <img
                  src="https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=200&q=80"
                  alt="Post"
                />
              </div>
              <div class="post-info">
                <h4>
                  <a class="text-line text-blog-tilte" href="#"
                    >The Thrill: Phố chứa nỗi nhớ cho Gen Z tìm về</a
                  >
                </h4>
                <div class="post-date">
                  <i class="fa-regular fa-clock"></i> 6 Jul 2025
                </div>
              </div>
            </div>
            <div class="post-item">
              <div class="post-thumbnail">
                <img
                  src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&q=80"
                  alt="Post"
                />
              </div>
              <div class="post-info">
                <h4>
                  <a class="text-line text-blog-tilte" href="#"
                    >Người tâm lý biến hóa với những vai diễn thú vị</a
                  >
                </h4>
                <div class="post-date">
                  <i class="fa-regular fa-clock"></i> 5 Jul 2025
                </div>
              </div>
            </div>
            <div class="post-item">
              <div class="post-thumbnail">
                <img
                  src="https://images.unsplash.com/photo-1556761175-b413da4baf72?w=200&q=80"
                  alt="Post"
                />
              </div>
              <div class="post-info">
                <h4>
                  <a class="text-line text-blog-tilte" href="#"
                    >Vì sao Mạnh Hùng - ông chú Toàn Shinbi vẫn chưa lấy Vợ</a
                  >
                </h4>
                <div class="post-date">
                  <i class="fa-regular fa-clock"></i> 4 Jul 2025
                </div>
              </div>
            </div>
          </div>

          <!-- Ad Banner -->
          <div class="ad-banner">
            <h3>SEO</h3>
            <p>YOU CAN BE HERE!</p>
            <button>Contact Us</button>
          </div>

          <!-- More Posts -->
          <div class="sidebar-widget">
            <div class="post-item">
              <div class="post-thumbnail">
                <img
                  src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=200&q=80"
                  alt="Post"
                />
              </div>
              <div class="post-info">
                <h4>
                  <a class="text-line text-blog-tilte" href="#"
                    >Vì sao Mạnh Hùng - ông chú Toàn Shinbi vẫn chưa lấy Vợ</a
                  >
                </h4>
                <div class="post-date">
                  <i class="fa-regular fa-clock"></i> 3 Jul 2025
                </div>
              </div>
            </div>
            <div class="post-item">
              <div class="post-thumbnail">
                <img
                  src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=200&q=80"
                  alt="Post"
                />
              </div>
              <div class="post-info">
                <h4>
                  <a class="text-line text-blog-tilte" href="#"
                    >Vì sao Mạnh Hùng - ông chú Toàn Shinbi vẫn chưa lấy Vợ Vì
                    sao Mạnh Hùng - ông chú Toàn Shinbi vẫn chưa lấy Vợ Vì sao
                    Mạnh Hùng - ông chú Toàn Shinbi vẫn chưa lấy Vợ Vì sao Mạnh
                    Hùng - ông chú Toàn Shinbi vẫn chưa lấy Vợ Vì sao Mạnh Hùng
                    - ông chú Toàn Shinbi vẫn chưa lấy Vợ
                  </a>
                </h4>
                <div class="post-date">
                  <i class="fa-regular fa-clock"></i> 2 Jul 2025
                </div>
              </div>
            </div>
          </div>
        </aside>
      </div>

      <!-- Related Posts -->

      <section class="related-posts">
        <div style="text-align: center">
          <h2
            style="
              display: inline-block;
              border-bottom: 2px solid #fff;
              width: 360px;
              padding-bottom: 4px;
            "
          >
            Các bài viết liên quan
          </h2>
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
      </section>
    </main>

    <!-- Footer -->
<?php get_footer(); ?>
