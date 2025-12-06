document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";
  const WP_HOME = window.WP_HOME;
  let sharedPostId = null;

  /* =========================================================
   *   CORE FUNC - Lấy Post ID từ slug trong URL
   * ========================================================= */
  
  async function getSlugFromPath() {
    const parts = location.pathname.split('/').filter(Boolean);
    // Giả sử slug luôn ở vị trí cuối: ['PXP_SSW', 'wordpress', 'info', 'lc2024']
    return parts[parts.length - 1] || null;
  }

  async function getSharedPostId() {
    if (sharedPostId) return sharedPostId;

    const slug = await getSlugFromPath();
    
    if (!slug) {
      console.warn("Không tìm thấy slug trong URL");
      return null;
    }
    
    try {
      // Fetch post_item by slug
      const res = await fetch(`${API_BASE}/post_item?slug=${slug}`);
      const data = await res.json();
      
      if (data && data.length > 0) {
        sharedPostId = data[0].id;
        console.log("✅ Post ID dùng chung:", sharedPostId, "từ slug:", slug);
        return sharedPostId;
      } else {
        console.error("Không tìm thấy post với slug:", slug);
        return null;
      }
    } catch (error) {
      console.error("Lỗi khi fetch post by slug:", error);
      return null;
    }
  }

  /* =========================================================
   *   UI EVENTS
   * ========================================================= */
  
  const container = document.querySelector(".brand-container");
  const nextBtn = document.querySelector(".next-btn");
  const prevBtn = document.querySelector(".prev-btn");

  if (nextBtn && prevBtn && container) {
    nextBtn.addEventListener("click", () => {
      container.scrollBy({ left: 300, behavior: "smooth" });
    });

    prevBtn.addEventListener("click", () => {
      container.scrollBy({ left: -300, behavior: "smooth" });
    });
  }

  /* =========================================================
   *   RENDER FUNCTIONS
   * ========================================================= */

  const postId = await getSharedPostId();
  
  if (!postId) {
    console.error("Không thể lấy Post ID. Dừng render.");
    return;
  }

  /** SECTION 1: Fetch Image Post (Top Content) */
  try {
    const topContentSection = document.querySelector("#top-content-section");
    const postRes = await fetch(`${API_BASE}/post_item/${postId}`);
    const post = await postRes.json();

    const postTitle = post.title.rendered || "No title";
    const postMeta = post.meta || {};
    const postLogo = postMeta.logo || "";
    const postLink = postMeta.post_link || "";

    topContentSection.innerHTML = `
      <div class="top-content-logo">
        <img
          class="top-content-logo-img"
          src="${postLogo}"
          alt="${postTitle}"
        />
      </div>
      <div class="site-info">
        <h2>${postTitle}</h2>
        <a href="${postLink}">https://www.carspassion.com</a>
        <div class="stars">★★★★★</div>
      </div>
    `;
  } catch (error) {
    console.error("Lỗi khi fetch top content:", error);
  }

  /** SECTION 2: Fetch Background Image */
  async function renderHeroBackground() {
    try {
      const res = await fetch(`${API_BASE}/post_item/${postId}`);
      const post = await res.json();

      const bgImage =
        post.meta?.bgr_image ||
        "http://localhost/PXP_SSW/wordpress/wp-content/themes/yourtheme/images/image_bgr.jpeg";

      const heroWrapper = document.querySelector(".hero-wrapper");
      if (heroWrapper) {
        heroWrapper.style.background = `url('${bgImage}') center/cover no-repeat`;
        heroWrapper.style.transition = "background 0.4s ease-in-out";
      }

      console.log("Background đã được render:", bgImage);
    } catch (err) {
      console.error("Lỗi khi fetch background:", err);
    }
  }
  await renderHeroBackground();

  /** SECTION 3: Fetch Left Content */
  try {
    const contentleft = document.querySelector("#content-left");
    const postRes = await fetch(`${API_BASE}/post_item/${postId}`);
    const post = await postRes.json();

    const postTitle = post.title.rendered || "No title";
    const postMeta = post.meta || {};
    const postDesc = postMeta.desc || "";

    contentleft.innerHTML = `
      <h3>${postTitle}</h3>
      <p>${postDesc}</p>
    `;
  } catch (error) {
    console.error("Lỗi khi fetch left content:", error);
  }

  /** SECTION 4: Fetch Right Content (Good & Bad) */
  try {
    const contentgb = document.querySelector("#goodabad");
    const postRes = await fetch(`${API_BASE}/post_item/${postId}`);
    const post = await postRes.json();

    const postMeta = post.meta || {};
    const postlikes = postMeta.likes || "";
    const posthates = postMeta.hates || "";

    const likes = JSON.parse(postlikes || "[]");
    const hates = JSON.parse(posthates || "[]");

    const likeHTML = likes.map(item => `<li>✅ ${item}</li>`).join("");
    const hateHTML = hates.map(item => `<li>❌ ${item}</li>`).join("");

    contentgb.innerHTML = `
      <div class="review-box">
        <div class="likes">
          <h4>Likes</h4>
          <ul>${likeHTML}</ul>
        </div>
        <div class="hates">
          <h4>Hates</h4>
          <ul>${hateHTML}</ul>
        </div>
      </div>
    `;
  } catch (error) {
    console.error("Lỗi khi fetch good/bad content:", error);
  }

  /** SECTION 5: Fetch Brand Container (Related Posts) */
  try {
    const detailsContainer = document.querySelector("#details-container");
    const cateRes = await fetch(`${API_BASE}/post_item?per_page=5`);
    const cate = await cateRes.json();

    const relatedPost = cate.filter(c => String(c.id) !== String(postId));

    relatedPost.forEach((banner) => {
      const meta = banner.meta || {};
      const image = meta.image || "";
      const title = banner?.title?.rendered || "No Title";
      const link = banner.link || "#"; // SỬA: Dùng link WordPress tự tạo

      const bannerHTML = `
        <div class="banner-card">
          <img
            src="${image}"
            alt="${title}"
            class="banner-card-image"
          />
          <a href="${link}" class="banner-card-btn">${title}</a>
        </div>
      `;
      detailsContainer.insertAdjacentHTML("beforeend", bannerHTML);
    });
  } catch (error) {
    console.error("Lỗi fetch related posts:", error);
  }

  /** SECTION 6: Breadcrumb */
  const breadcrumb = document.querySelector(".breadcrumb");
  try {
    const res = await fetch(`${API_BASE}/post_item/${postId}`);
    const blog = await res.json();
    
    const title = blog?.title?.rendered || "Banner";

    const bannerHTML = `
      <a href="${WP_HOME}"><i class="fa-solid fa-house"></i> Streaming Sites</a> /
      <a href="${WP_HOME}/categories/">Category</a> /
      <span>${title}</span>
    `;

    breadcrumb.insertAdjacentHTML("beforeend", bannerHTML);
  } catch (error) {
    console.error("Lỗi khi tải breadcrumb:", error);
  }
});