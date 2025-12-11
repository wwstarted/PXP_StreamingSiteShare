document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";
  const WP_HOME = window.WP_HOME;

  const [allCate, allPosts] = await Promise.all([
    fetch(`${API_BASE}/categories?per_page=100`).then(r => r.json()),
    fetch(`${API_BASE}/posts?per_page=100`).then(r => r.json()),
  ]);

  const slug = location.pathname.split('/').filter(Boolean).pop();
  let currentCate = allCate.find(c => c.slug === slug) || allCate[0];
  let currentCateId = currentCate.id;

  async function renderBannerSection() {
    const cateMeta = currentCate.meta || {};
    const cateThumbnail = cateMeta?.thumbnail || "";
    const cateShortDesc = currentCate.description || ""; 

    const bannerRes = await fetch(`${API_BASE}/posts?per_page=100`);
    const banners = await bannerRes.json();

    const relatedBanners4 = banners.filter(b =>
      Array.isArray(b.id_cate_post) &&
      b.id_cate_post.map(String).includes(String(currentCateId))
    );

     const shuffled = relatedBanners4.sort(() => Math.random() - 0.5);

    const relatedBanners = shuffled.slice(0, 4);



    document.querySelector("#banner-section").innerHTML = `
      <div class="banner-left">
        <img src="${cateThumbnail}" alt="${currentCate.name}" />
      </div>
      <div class="banner-right">
        <h1>${currentCate.name}</h1>
        <p>${cateShortDesc}</p>
        <div class="platforms">
          ${
            relatedBanners.length
              ? relatedBanners
                  .map(
                    b => `
            <a href="${b.link || "#"}" target="_blank">
              <img src="${b.bgr_image || ""}" />
            </a>`
                  )
                  .join("")
              : "<p>No banners found.</p>"
          }
        </div>
      </div>
    `;
  }

  // ===================================== content top =======================================

  async function renderContentTop() {
    document
      .querySelector("#right_content_top")
      .insertAdjacentHTML(
        "beforeend",
        `
      <h2>${currentCate.name}</h2>
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

  // ======================================= content bottom =======================
  async function renderContentBottom() {
    const rightContent = document.querySelector("#right_content_bottom");

    const posts = allPosts
      .filter(p => {
        const cats = p.categories || [];
        return cats.includes(currentCateId);
      })
      .sort((a, b) => (b.popularity || 0) - (a.popularity || 0));

    if (!posts.length) {
      rightContent.insertAdjacentHTML("beforeend", "<p>No posts.</p>");
      return;
    }

    const rows = posts
      .map((p, i) => {
        const logo = p.logo || "https://via.placeholder.com/50";
        const popularity = p.popularity || 0;
        const title = p.title.rendered;
        const link = p.link;

        return `
        <a href="${link}" class="table-row">
          <span class="rank-badge">${i + 1}</span>
          
          <img src="${logo}" alt="${title}" />
          
          <span class="post-title">${title}</span>
          
          <div class="popularity-wrapper">
            <div class="bar">
              <div class="fill" style="width:${popularity}%"></div>
            </div>
            <span class="popularity-percent">${popularity}%</span>
          </div>
          
          <div class="row-icon">
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </a>`;
      })
      .join("");

    rightContent.insertAdjacentHTML("beforeend", rows);
  }

  // =================================== related cate =======================

  async function renderRelatedCate() {
    const wrap = document.querySelector(".left_content");

    const otherCate2 = allCate.filter(c => c.id !== currentCateId);

     const otherCate = otherCate2.filter((cate) => {
    const v = cate.meta?._cate_visible;
    return v === "1" || v === 1 || v === true;
  });

    otherCate.forEach(c => {
      const cMeta = c.meta || {};
      const cThumb = cMeta.thumbnail || "https://via.placeholder.com/80";
      const categoryTitle = c.name;
      const categoryLink = c.link;

      //==================== get posts same category ==================
      const posts = allPosts.filter(p => {
        const cats = p.categories || [];
        return cats.includes(c.id);
      });

      const totalPosts = posts.length;
      const top5 = posts.slice(0, 5);
      const remain = totalPosts - top5.length;

      // mini logo (limit 5)
      const logosHTML = top5
        .map(p => `<img src="${p.logo || 'https://via.placeholder.com/26'}" alt="${p.title.rendered}" />`)
        .join("");

      // Button text
      const buttonText = remain > 0 ? `+${remain} sites` : '';

      wrap.insertAdjacentHTML(
        "beforeend",
        `
      <a href="${categoryLink}" class="related-item">
        <img src="${cThumb}" class="related-icon" alt="${categoryTitle}" />
        
        <div class="info">
          <div class="category-header">
            <h3>${categoryTitle}</h3>
            <span class="count-badge">${totalPosts}</span>
          </div>
          
          <div class="mini-logos">
            ${logosHTML}
            ${remain > 0 ? `<a href="${categoryLink}" class="visit-btn-cate" onclick="event.stopPropagation()">${buttonText}</a>` : ''}
          </div>
        </div>
      </a>
      `
      );
    });
  }

  async function renderBrandSection() {
    const brandContainer = document.querySelector("#brand-container");

    const randomPosts = allPosts.slice(0, 7);

    randomPosts.forEach(p => {
      const img = p.bgr_image || "https://via.placeholder.com/400x200";
      const logo = p.logo || "";
      const popularity = p.popularity || "";
      const title = p.title.rendered;
      const link = p.link;

      // Logo HTML - placeholder nếu không có logo
      const logoHTML = logo 
        ? `<img class="brand-logo" src="${logo}" alt="${title}" />` 
        : `<div class="brand-logo-placeholder">
             <i class="fa-solid fa-fire"></i>
           </div>`;

      // Tags HTML
      const tagsHTML = `
      <div class="brand-tags">
        <span class="tag">Popular</span>
        ${popularity ? `<span class="tag">${popularity}%</span>` : ''}
      </div>
    `;

      brandContainer.insertAdjacentHTML(
        "beforeend",
        `
      <div class="banner-card">
        <!-- Background Image -->
        <img src="${img}" class="banner-card-image" alt="${title}" />
        
        <!-- Gradient Overlay -->
        <div class="banner-card-overlay"></div>
        
        <!-- Glass Info Panel -->
        <div class="banner-card-info">
          ${logoHTML}
          
          <h3 class="brand-title">${title}</h3>
          
          ${tagsHTML}
          
          <a href="${link}" class="banner-card-btn">
            <span>View Details</span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>
      `
      );
    });
  }




  renderBannerSection();
  renderContentTop();
  renderContentBottom();
  renderRelatedCate();
  renderBrandSection();
});