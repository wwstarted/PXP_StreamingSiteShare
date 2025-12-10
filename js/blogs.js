document.addEventListener("DOMContentLoaded", async () => {
  const bannerContainer = document.querySelector(".hero-section");
  try {
    const res = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blogs?per_page=100");
    const blogs = await res.json();

        const visibleBlogs = blogs.filter((blog) => {
      const isVisible = blog.meta?._blogs_visible;
      return isVisible === "1" || isVisible === true || isVisible === 1;
    });


    if (!Array.isArray(visibleBlogs) || visibleBlogs.length === 0) return;

    const randomBlog = visibleBlogs[Math.floor(Math.random() * visibleBlogs.length)];

    const meta = randomBlog.meta || {};
    const bg_short_desc = meta.bg_short_desc || "";
    const title = randomBlog?.title?.rendered || "Banner";
    const bg_thumbnail = meta.bg_thumbnail || "";

    const bannerHTML = `
      <div class="hero-content">
        <h1>${title}</h1>
        <p>${bg_short_desc}</p>
        <div class="hero-buttons">
          <a href="${randomBlog.link || '#'}" class="btn btn-primary">Get started</a>
          <a href="${WP_HOME}/404notfound/" class="btn btn-secondary">Contacts</a>
        </div>
      </div>
      <div class="hero-image">
        <img src="${bg_thumbnail}" alt="Hero Image" />
      </div>
    `;

    bannerContainer.insertAdjacentHTML("beforeend", bannerHTML);

  } catch (error) {
    console.error("Lỗi khi tải banner:", error);
  }


  /** render Bai Viet theo chu de */
 
});


document.addEventListener("DOMContentLoaded", async()=>{


  const rootContainer = document.querySelector(".blog-section"); 


  try {
    const cateRes = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blog_category");
    const categories = await cateRes.json();

    for (const cate of categories) {
      const cateName = cate.name;
      const cateId = cate.id;

      const blogRes = await fetch(
        `http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blogs?blog_category=${cateId}&per_page=3`
      );
      const blogs = await blogRes.json();

      if (!Array.isArray(blogs) || blogs.length === 0) continue; // bỏ qua category trống

      const blogCardsHTML = blogs
        .map((blog) => {
          const meta = blog.meta || {};
          const title = blog?.title?.rendered || "Không có tiêu đề";
          const desc = meta.bg_short_desc || "Không có mô tả.";
          const avatar = meta.bg_avatar || "https://via.placeholder.com/500x300?text=No+Image";
          const author = meta.bg_author || "Admin";
          const date = new Date(blog.date).toLocaleDateString("vi-VN");

          return `
            <article class="blog-card">
              <div class="card-header-blog">
                <h3 class="text-line card-title">${title}</h3>
                <p class="text-line card-description-blog">${desc}</p>
                <div class="card-meta">
                  <div class="author-info">
                    <div class="author-avatar">👤</div>
                    <div class="author-details">
                      <span class="author-name">${author}</span>
                      <span class="post-date">${date}</span>
                    </div>
                  </div>
                  <a href="${blog.link || '#'}" class="view-post-link">View Post →</a>
                </div>
              </div>
              <div class="card-image">
                <div class="image-badge">LIVE SLOT</div>
                <img src="${avatar}" alt="${title}" />
                <div class="brand-logo-blog">
                  <div class="brand-icon">▶</div>
                  <span>Streamingsites</span>
                </div>
              </div>
            </article>
          `;
        })
        .join("");
      //Render section đầy đủ
      const sectionHTML = `
        <section class="blog-section">
          <div class="section-header">
            <h2 class="section-title">
              <span class="code-icon"><span>&lt;/&gt;</span></span>
              Bài viết chủ đề ${cateName}
            </h2>
            <a href="${WP_HOME}/404notfound" class="view-all-btn">
              <span class="arrow"><i class="fa-solid fa-arrow-right"></i></span>
            </a>
          </div>
          <div class="blog-grid">${blogCardsHTML}</div>
        </section>
      `;

      //Thêm section vào wrapper
      rootContainer.insertAdjacentHTML("beforeend", sectionHTML);
    }
  } catch (err) {
    console.error("Lỗi khi tải dữ liệu:", err);
    rootContainer.innerHTML = "<p>Lỗi tải dữ liệu từ API.</p>";
  }
})


