document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "https://nano4me.org/wp-json/wp/v2";

  // Lấy slug từ pathname
  function getSlugFromPath() {
    const parts = location.pathname.split("/").filter(Boolean);
    return parts[parts.length - 1] || null;
  }

  const blogId = getSlugFromPath();
  console.log("✅ Post ID dùng chung:", blogId);

  // Helper function: Format date
  function formatDate(dateString) {
    if (!dateString) return "No date";
    const date = new Date(dateString);
    const options = { year: "numeric", month: "short", day: "numeric" };
    return date.toLocaleDateString("en-US", options);
  }

  // ========================================
  // 1. FETCH RELATED BLOGS
  // ========================================
  const relatedBlogs = document.querySelector(".blog-grid");
  if (relatedBlogs) {
    try {
      const res = await fetch(`${API_BASE}/blogs?per_page=100`);
      const blogs = await res.json();

      blogs.forEach((blog) => {
        const meta = blog.meta || {};
        const shortDesc = meta.bg_short_desc || "";
        const title = blog?.title?.rendered || "Untitled";
        const featuredImage = meta.bg_thumbnail || "";
        
        // ✅ Lấy author từ custom fields
        const authorName = blog.author_name || "Unknown Author";
        const authorAvatar = blog.author_avatar || "";
        const postDate = formatDate(blog.date);

        const bannerHTML = `
          <div class="blog-card">
            <div class="blog-image">
              <img src="${featuredImage}" alt="${title}" />
            </div>
            <div class="blog-content">
              <h3 class="text-line blog-title">${title}</h3>
              <p class="text-line blog-description">${shortDesc}</p>
              <div class="blog-meta">
                <img class="blog-meta-avatar" src="${authorAvatar}" alt="${authorName}" />
                <span>${authorName} | ${postDate}</span>
              </div>
              <a href="${blog.link || "#"}" class="read-more">
                <span>Read more</span>
                <i style="font-size: 10px" class="fa-solid fa-chevron-right"></i>
              </a>
            </div>
          </div>
        `;

        relatedBlogs.insertAdjacentHTML("beforeend", bannerHTML);
      });
    } catch (error) {
      console.error("Lỗi khi tải related blogs:", error);
    }
  }

  // ========================================
  // 2. FETCH SIDEBAR POSTS
  // ========================================
  const sidebar = document.querySelector(".sidebar-widget");
  if (sidebar) {
    try {
      const res = await fetch(`${API_BASE}/blogs?per_page=100`);
      const blogs = await res.json();

      blogs.forEach((blog) => {
        const meta = blog.meta || {};
        const featuredImage = meta.bg_thumbnail || "";
        const title = blog?.title?.rendered || "Untitled";
        const postDate = formatDate(blog.date);

        const bannerHTML = `
          <div class="post-item">
            <div class="post-thumbnail">
              <img src="${featuredImage}" alt="${title}" />
            </div>
            <div class="post-info">
              <h4>
                <a class="text-line text-blog-tilte" href="${blog.link || "#"}">${title}</a>
              </h4>
              <div class="post-date">
                <i class="fa-regular fa-clock"></i> ${postDate}
              </div>
            </div>
          </div>
        `;

        sidebar.insertAdjacentHTML("beforeend", bannerHTML);
      });
    } catch (error) {
      console.error("Lỗi khi tải sidebar:", error);
    }
  }

  // ========================================
  // 3. FETCH ARTICLE HEADER
  // ========================================
  const blog_header = document.querySelector(".article-header");
  if (blog_header) {
    try {
      const res = await fetch(
        `${API_BASE}/blogs?slug=${encodeURIComponent(blogId)}`
      );
      const blogs = await res.json();
      const blog = blogs[0];

      // ✅ Lấy author từ custom fields
      const authorName = blog.author_name || "Unknown Author";
      const authorAvatar = blog.author_avatar || "";
      const postDate = formatDate(blog.date);
      const title = blog?.title?.rendered || "Untitled";

      // Lấy tags
      const tagIds = blog.blog_tag || [];
      let tagsHTML = "";

      if (tagIds.length > 0) {
        const tagPromises = tagIds.map(async (id) => {
          const tagRes = await fetch(`${API_BASE}/blog_tag/${id}`);
          const tagData = await tagRes.json();
          return `<span class="tag">${tagData.name}</span>`;
        });

        const tags = await Promise.all(tagPromises);
        tagsHTML = tags.join("");
      }

      const bannerHTML = `
        <div class="article-tags">
          ${tagsHTML || "<span class='tag'>No Tag</span>"}
        </div>
        <h1>${title}</h1>
        <div class="article-meta">
          <div class="article-meta-left">
            <span class="article-views">
              <i class="fa-solid fa-eye"></i>
              46 lượt xem
            </span>
            <div class="author">
              <img src="${authorAvatar}" alt="${authorName}" />
              <span>${authorName} — ${postDate}</span>
            </div>
          </div>
          <div class="article-actions">
            <a href="https://x.com/"><i class="fa-brands fa-twitter"></i></a>
            <a href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://ca.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
          </div>
        </div>
      `;

      blog_header.insertAdjacentHTML("beforeend", bannerHTML);
    } catch (error) {
      console.error("Lỗi khi tải blog header:", error);
    }
  }

  // ========================================
  // 4. FETCH ARTICLE CONTENT & GENERATE TOC
  // ========================================
  const blogDesc = document.querySelector("#article-content");
  if (blogDesc) {
    try {
      const res = await fetch(
        `${API_BASE}/blogs?slug=${encodeURIComponent(blogId)}`
      );
      const blogs = await res.json();
      const blog = blogs[0];

      const meta = blog.meta || {};
      const desc = meta._blog_desc || "<p>Không có nội dung mô tả.</p>";

      blogDesc.innerHTML = desc;
      generateTableOfContents();

      setTimeout(() => {
        if (typeof initScrollSpy === "function") {
          initScrollSpy();
        }
      }, 500);
    } catch (error) {
      console.error("Lỗi khi tải blog content:", error);
    }
  }

  // ========================================
  // 5. FETCH BREADCRUMB
  // ========================================
  const breadcrumb = document.querySelector(".breadcrumb_blog");
  if (breadcrumb) {
    try {
      const res = await fetch(
        `${API_BASE}/blogs?slug=${encodeURIComponent(blogId)}`
      );
      const blogs = await res.json();
      const blog = blogs[0];

      const title = blog?.title?.rendered || "Untitled";

      const bannerHTML = `
        <a href="${WP_HOME}"><i class="fa-solid fa-house"></i> Streaming Sites</a> /
        <a href="${WP_HOME}/blog/">Blog</a> /
        <span>${title}</span>
      `;

      breadcrumb.insertAdjacentHTML("beforeend", bannerHTML);
    } catch (error) {
      console.error("Lỗi khi tải breadcrumb:", error);
    }
  }
});

// ========================================
// GENERATE TABLE OF CONTENTS
// ========================================
function generateTableOfContents() {
  const content = document.getElementById("article-content");
  if (!content) return;

  const headings = content.querySelectorAll("h2, h3");
  if (headings.length === 0) return;

  const toc = document.createElement("div");
  toc.className = "table-of-contents";
  toc.innerHTML = `
    <div class="toc-header">
      <h3><i class="fa-solid fa-list-ul"></i> Nội dung chính</h3>
      <i class="fa-solid fa-chevron-down toc-toggle"></i>
    </div>
    <div class="toc-content">
      <ul class="toc-list"></ul>
    </div>
  `;
  content.prepend(toc);

  const tocList = toc.querySelector(".toc-list");
  const tocHeader = toc.querySelector(".toc-header");
  const tocContent = toc.querySelector(".toc-content");
  const toggleIcon = toc.querySelector(".toc-toggle");

  tocHeader.addEventListener("click", () => {
    tocContent.classList.toggle("show");
    toggleIcon.classList.toggle("rotate");
  });

  headings.forEach((heading, index) => {
    const id = `section-${index}`;
    heading.id = id;

    const li = document.createElement("li");
    const a = document.createElement("a");
    a.href = `#${id}`;
    a.innerHTML = `<span class="toc-number">${index + 1}.</span> <span>${heading.textContent}</span>`;

    if (heading.tagName === "H3") li.classList.add("sub-item");

    li.appendChild(a);
    tocList.appendChild(li);
  });
}