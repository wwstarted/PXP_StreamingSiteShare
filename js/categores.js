document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";
  const WP_HOME = window.WP_HOME;
  let sharedCateId = null;

  /* =========================================================
   *   A. CORE FUNC
   * ========================================================= */

  async function getSlugFromPath() {
    const parts = location.pathname.split('/').filter(Boolean);
    return parts[parts.length - 1] || null;
  }

  async function getSharedCateId() {
    if (sharedCateId) return sharedCateId;

    const slug = await getSlugFromPath();
    
    if (!slug) {
      console.warn("Không tìm thấy slug trong URL");
      const allCateRes = await fetch(`${API_BASE}/cate_post?per_page=1`);
      const allCategories = await allCateRes.json();
      if (allCategories.length > 0) {
        sharedCateId = allCategories[0].id;
      }
    } else {
      // Fetch category by slug
      const res = await fetch(`${API_BASE}/cate_post?slug=${slug}`);
      const data = await res.json();
      
      if (data && data.length > 0) {
        sharedCateId = data[0].id;
      }
    }

    console.log("Cate ID dùng chung:", sharedCateId, "từ slug:", slug);
    return sharedCateId;
  }

// ============================
  (function initUI() {
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

    const h_prevBtn = document.querySelector(".banner-section-prev");
    const h_nextBtn = document.querySelector(".banner-section-back");
    const slider = document.querySelector(".banner-section-slide");

    if (h_prevBtn && h_nextBtn && slider) {
      h_prevBtn.addEventListener("click", () => {
        slider.scrollBy({ left: -320, behavior: "smooth" });
      });
      h_nextBtn.addEventListener("click", () => {
        slider.scrollBy({ left: 320, behavior: "smooth" });
      });
    }
  })();


  window.toggleContent = function (button) {
    const section = button.closest(".info-section");
    const content = section.querySelector(".info-content");
    const btnText = button.querySelector(".text");
    const fadeOverlay = section.querySelector(".fade-overlay");

    content.classList.toggle("expanded");
    button.classList.toggle("expanded");

    if (content.classList.contains("expanded")) {
      btnText.textContent = "Read Less";
      fadeOverlay.classList.add("hidden");
    } else {
      btnText.textContent = "Read More";
      fadeOverlay.classList.remove("hidden");
    }
  };


  //  ========================================================= */
  async function renderBannerSection() {
    try {
      const cateId = await getSharedCateId();
      const bannerSection = document.querySelector("#banner-section");

      const cateRes = await fetch(`${API_BASE}/cate_post/${cateId}`);
      const category = await cateRes.json();

      const bannerRes = await fetch(`${API_BASE}/small_banners?per_page=100`);
      const banners = await bannerRes.json();

      const cateMeta = category.meta || {};
      const cateThumbnail = cateMeta.thumbnail || "";
      const cateShortDesc = cateMeta.short_desc || "";

      const relatedBanners = banners.filter((b) => {
        const idList = b.meta?.id_cate_post;
        if (Array.isArray(idList)) return idList.map(String).includes(String(cateId));
        if (["string", "number"].includes(typeof idList)) return String(idList) === String(cateId);
        return false;
      });

      bannerSection.innerHTML = `
        <div class="banner-left">
          <img src="${cateThumbnail}" alt="${category.title.rendered || "No title"}" />
        </div>
        <div class="banner-right">
          <h1>${category.title.rendered || "Không có tiêu đề"}</h1>
          <p>${cateShortDesc}</p>
          <div class="platforms">
            ${
              relatedBanners.length > 0
                ? relatedBanners.map(
                    (b) => `
                      <a href="${b.meta?.sbanner_link || "#"}" target="_blank">
                        <img src="${b.meta?.sbanner_image || ""}" alt="banner" />
                      </a>
                    `
                  ).join("")
                : "<p>Không có banner nào thuộc danh mục này.</p>"
            }
          </div>
        </div>
      `;
    } catch (error) {
      console.error("Lỗi renderBannerSection:", error);
    }
  }


  // ---- SECTION 2: Content Top
  async function renderContentTop() {
    try {
      const cateId = await getSharedCateId();
      const rightContent = document.querySelector("#right_content_top");

      const cateRes = await fetch(`${API_BASE}/cate_post/${cateId}`);
      const cate = await cateRes.json();

      const title = cate?.title?.rendered || "Banner";
      const html = `
        <h2>${title}</h2>
        <div class="table-header">
          <span></span>
          <span></span>
          <span style="margin-left: 10px">
            Name<i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 3px"></i>
          </span>
          <span style="margin-left: -10px">
            Popularity<i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 3px"></i>
          </span>
        </div>
      `;
      rightContent.insertAdjacentHTML("beforeend", html);
    } catch (error) {
      console.error("Lỗi renderContentTop:", error);
    }
  }


  // ---- SECTION 3: Content Bottom
  async function renderContentBottom() {
    try {
      const cateId = await getSharedCateId();
      const rightContent = document.querySelector("#right_content_bottom");

      const postsRes = await fetch(`${API_BASE}/post_item?per_page=100`);
      let posts = await postsRes.json();

      posts = posts
        .filter(p => String(p.meta?.id_cate) === String(cateId))
        .sort((a, b) => (b.meta?.popularity || 0) - (a.meta?.popularity || 0));

      if (!posts.length) {
        rightContent.insertAdjacentHTML("beforeend", "<p>Không có bài viết nào.</p>");
        return;
      }

      const rowsHTML = posts.map((post, index) => {
        const popularity = parseInt(post.meta?.popularity || 0);
        const logo = post.meta?.logo || "https://via.placeholder.com/50";
        const title = post.title?.rendered || "Không có tiêu đề";

        return `
          <a href="${post.link}" class="table-row">
            <span>${index + 1}</span>
            <img src="${logo}" alt="Logo" />
            <span>${title}</span>
            <div class="bar"><div class="fill" style="width: ${popularity}%"></div></div>
          </a>
        `;
      }).join("");

      rightContent.insertAdjacentHTML("beforeend", rowsHTML);
    } catch (error) {
      console.error("Lỗi renderContentBottom:", error);
    }
  }

  // ---- SECTION 4: Banner Slide
  async function renderBannerSlide() {
    try {
      const related = document.querySelector("#banner-slide");
      const res = await fetch(`${API_BASE}/banner`);
      const banners = await res.json();

      banners.forEach((banner) => {
        const meta = banner.meta || {};
        const image = meta.image || "";
        const link = meta.link || "#";
        const title = meta.title || banner.title?.rendered || "Banner";

        const html = `
          <div class="banner-card">
            <img src="${image}" alt="${title}" class="banner-card-image" />
            <a href="${link}" class="banner-card-btn">${title}</a>
          </div>
        `;

        related.insertAdjacentHTML("beforeend", html);
      });
    } catch (error) {
      console.error("Lỗi renderBannerSlide:", error);
    }
  }

  // ---- SECTION 5: Related Categories
  async function renderRelatedCate() {
    try {
      const cateId = await getSharedCateId();
      const relatedContainer = document.querySelector(".left_content");

      const allCateRes = await fetch(`${API_BASE}/cate_post?per_page=100`);
      const allCategories = await allCateRes.json();
      const relatedCates = allCategories.filter(c => String(c.id) !== String(cateId));

      const postsRes = await fetch(`${API_BASE}/post_item?per_page=100`);
      const allPosts = await postsRes.json();

      for (const cate of relatedCates) {
        const cateMeta = cate.meta || {};
        const cateLogo = cateMeta.thumbnail || "https://via.placeholder.com/80";
        const cateTitle = cate.title?.rendered || "No Title";
        const cateLink = cate.link || "#"; 

        const posts = allPosts
          .filter(p => String(p.meta?.id_cate) === String(cate.id))
          .slice(0, 5);

        const logosHTML = posts.map(p => {
          const logo = p.meta?.logo || "https://via.placeholder.com/50";
          return `<img src="${logo}" alt="icon" />`;
        }).join("");

        const totalPosts = allPosts.filter(p => String(p.meta?.id_cate) === String(cate.id)).length;
        const remains = totalPosts - posts.length;

        const remainHTML =
          remains > 0
            ? `<a href="${cateLink}" class="visit-btn-cate">+${remains}</a>` // SỬA: Dùng cateLink
            : "";

        const html = `
          <div class="related-item">
            <img src="${cateLogo}" alt="Logo" />
            <div class="info">
              <h3>${cateTitle}</h3>
              <div class="mini-logos">
                ${logosHTML}
                ${remainHTML}
              </div>
            </div>
          </div>
        `;
        relatedContainer.insertAdjacentHTML("beforeend", html);
      }
    } catch (error) {
      console.error("Lỗi renderRelatedCate:", error);
    }
  }

  // ---- SECTION 6: Brand Section
  async function renderBrandSection() {
    try {
      const brandContainer = document.querySelector("#brand-container");
      const cateRes = await fetch(`${API_BASE}/post_item?per_page=5`);
      const posts = await cateRes.json();

      posts.forEach((banner) => {
        const meta = banner.meta || {};
        const image = meta.image || "";
        const title = banner?.title?.rendered || "No Title";

        const html = `
          <div class="banner-card">
            <img src="${image}" alt="${title}" class="banner-card-image" />
            <a href="${WP_HOME}/detailscate/?post_id=${banner.id}" class="banner-card-btn">${title}</a>
          </div>
        `;
        brandContainer.insertAdjacentHTML("beforeend", html);
      });
    } catch (error) {
      console.error("Lỗi renderBrandSection:", error);
    }
  }

  // Gọi các hàm render
  renderBannerSection();
  renderContentTop();
  renderContentBottom();
  renderBannerSlide();
  renderRelatedCate();
  renderBrandSection();
});