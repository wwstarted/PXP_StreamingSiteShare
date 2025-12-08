document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";
  const WP_HOME = window.WP_HOME;

  /* ============================================
   *  A. FETCH CHỈ 2 LẦN — TOÀN TRANG DÙNG CHUNG
   * ============================================ */
  const [allCate, allPosts] = await Promise.all([
    fetch(`${API_BASE}/cate_post?per_page=100`).then(r => r.json()),
    fetch(`${API_BASE}/post_item?per_page=100`).then(r => r.json()),
  ]);

  /* ============================================
   *  B. LẤY CATEGORY ID TỪ URL (slug page)
   * ============================================ */
  const slug = location.pathname.split('/').filter(Boolean).pop();
  let currentCate = allCate.find(c => c.slug === slug) || allCate[0];
  let currentCateId = currentCate.id;

  /* ========================================================================== */
  /*  C. RENDER BANNER SECTION (TOP)                                            */
  /* ========================================================================== */

  async function renderBannerSection() {
    const cateMeta = currentCate.meta || {};
    const cateThumbnail = cateMeta.thumbnail || "";
    const cateShortDesc = cateMeta.short_desc || "";

    // Lấy banner thuộc cate này
    const bannerRes = await fetch(`${API_BASE}/small_banners?per_page=100`);
    const banners = await bannerRes.json();

    const relatedBanners = banners.filter(b =>
      Array.isArray(b.meta?.id_cate_post) &&
      b.meta.id_cate_post.map(String).includes(String(currentCateId))
    );

    document.querySelector("#banner-section").innerHTML = `
      <div class="banner-left">
        <img src="${cateThumbnail}" alt="${currentCate.title.rendered}" />
      </div>
      <div class="banner-right">
        <h1>${currentCate.title.rendered}</h1>
        <p>${cateShortDesc}</p>
        <div class="platforms">
          ${
            relatedBanners.length
              ? relatedBanners
                  .map(
                    b => `
            <a href="${b.meta?.sbanner_link || "#"}" target="_blank">
              <img src="${b.meta?.sbanner_image || ""}" />
            </a>`
                  )
                  .join("")
              : "<p>No banners found.</p>"
          }
        </div>
      </div>
    `;
  }

  /* ========================================================================== */
  /*  D. CONTENT TOP                                                            */
  /* ========================================================================== */

  async function renderContentTop() {
    document
      .querySelector("#right_content_top")
      .insertAdjacentHTML(
        "beforeend",
        `
      <h2>${currentCate.title.rendered}</h2>
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
    `
      );
  }

  /* ========================================================================== */
  /*  E. CONTENT BOTTOM (LIST POST THUỘC CATEGORY NÀY)                          */
  /* ========================================================================== */

  async function renderContentBottom() {
    const rightContent = document.querySelector("#right_content_bottom");

    const posts = allPosts
      .filter(
        p =>
          Array.isArray(p.meta?.id_cate_post) &&
          p.meta.id_cate_post.map(String).includes(String(currentCateId))
      )
      .sort((a, b) => (b.meta?.popularity || 0) - (a.meta?.popularity || 0));

    if (!posts.length) {
      rightContent.insertAdjacentHTML("beforeend", "<p>No posts.</p>");
      return;
    }

    const rows = posts
      .map((p, i) => {
        const logo = p.meta?.logo || "https://via.placeholder.com/50";
        const popularity = p.meta?.popularity || 0;
        return `
        <a href="${p.link}" class="table-row">
          <span>${i + 1}</span>
          <img src="${logo}" />
          <span>${p.title.rendered}</span>
          <div class="bar"><div class="fill" style="width:${popularity}%"></div></div>
        </a>`;
      })
      .join("");

    rightContent.insertAdjacentHTML("beforeend", rows);
  }

  /* ========================================================================== */
  /*  F. RELATED CATEGORIES                                                     */
  /* ========================================================================== */

  async function renderRelatedCate() {
    const wrap = document.querySelector(".left_content");

    const otherCate = allCate.filter(c => c.id !== currentCateId);

    otherCate.forEach(c => {
      const cMeta = c.meta || {};
      const cThumb = cMeta.thumbnail || "https://via.placeholder.com/80";

      // lấy post thuộc cate đó
      const posts = allPosts.filter(
        p =>
          Array.isArray(p.meta?.id_cate_post) &&
          p.meta.id_cate_post.map(String).includes(String(c.id))
      );

      const top5 = posts.slice(0, 5);

      const logos = top5
        .map(p => `<img src="${p.meta?.logo || ""}" />`)
        .join("");

      const remain = posts.length - top5.length;

      wrap.insertAdjacentHTML(
        "beforeend",
        `
        <div class="related-item">
          <img src="${cThumb}" />
          <div class="info">
            <h3>${c.title.rendered}</h3>
            <div class="mini-logos">
              ${logos}
              ${
                remain > 0
                  ? `<a href="${c.link}" class="visit-btn-cate">+${remain}</a>`
                  : ""
              }
            </div>
          </div>
        </div>
      `
      );
    });
  }

  /* ========================================================================== */
  /*  G. BRAND SECTION                                                          */
  /* ========================================================================== */

  async function renderBrandSection() {
    const brandContainer = document.querySelector("#brand-container");

    const randomPosts = allPosts.slice(0, 5);

    randomPosts.forEach(p => {
      const img = p.meta?.image || "";
      brandContainer.insertAdjacentHTML(
        "beforeend",
        `
        <div class="banner-card">
          <img src="${img}" class="banner-card-image" />
          <a href="${WP_HOME}/detailscate/?post_id=${p.id}" class="banner-card-btn">
            ${p.title.rendered}
          </a>
        </div>
      `
      );
    });
  }

  /* ========================================================================== */
  /*  H. BANNER SLIDE                                                           */
  /* ========================================================================== */

  async function renderBannerSlide() {
    const related = document.querySelector("#banner-slide");
    const banners = await fetch(`${API_BASE}/banner`).then(r => r.json());

    banners.forEach(b => {
      const meta = b.meta || {};
      related.insertAdjacentHTML(
        "beforeend",
        `
        <div class="banner-card">
          <img src="${meta.image || ""}" class="banner-card-image" />
          <a href="${meta.link || "#"}" class="banner-card-btn">
            ${meta.title || b.title.rendered}
          </a>
        </div>
      `
      );
    });
  }

  /* ========================================================================== */
  /*  RUN ALL                                                                   */
  /* ========================================================================== */

  renderBannerSection();
  renderContentTop();
  renderContentBottom();
  renderRelatedCate();
  renderBrandSection();
  renderBannerSlide();
});
