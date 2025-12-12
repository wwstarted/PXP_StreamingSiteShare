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

      // ✅ CODE ĐÚNG:
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
        ${remain > 0 ? `<span class="visit-btn-cate">${buttonText}</span>` : ''}
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

async function renderStatsInsights() {
  // Get posts for current category
  const posts = allPosts
    .filter(p => {
      const cats = p.categories || [];
      return cats.includes(currentCateId);
    })
    .sort((a, b) => (b.popularity || 0) - (a.popularity || 0));

  if (!posts.length) {
    document.querySelector(".stats-insights-section").style.display = "none";
    return;
  }

  // Calculate statistics
  const totalPosts = posts.length;
  const avgPopularity = Math.round(
    posts.reduce((sum, p) => sum + (p.popularity || 0), 0) / totalPosts
  );
  const trendingCount = posts.filter(p => (p.popularity || 0) >= 70).length;

  // Update stat cards with animation
  animateNumber("total-posts", totalPosts);
  animateNumber("avg-popularity", avgPopularity, "%");
  animateNumber("trending-count", trendingCount);

  // Render Top 3 Podium
  const top3 = posts.slice(0, 3);
  renderPodium(top3);

  // Render Popularity Chart
  renderPopularityChart(posts);
}

// Animate numbers counting up
function animateNumber(elementId, target, suffix = "") {
  const element = document.getElementById(elementId);
  let current = 0;
  const increment = target / 30;
  const duration = 1000;
  const stepTime = duration / 30;

  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    element.textContent = Math.floor(current) + suffix;
  }, stepTime);
}

// Render Top 3 Podium
function renderPodium(top3) {
  const podiumContainer = document.getElementById("podium-container");
  
  // Order: 2nd, 1st, 3rd (for visual layout)
  const order = [
    top3[1], // 2nd place
    top3[0], // 1st place  
    top3[2]  // 3rd place
  ];

  order.forEach((post, index) => {
    if (!post) return;

    const positions = ['second-place', 'first-place', 'third-place'];
    const podiumItem = podiumContainer.querySelector(`.${positions[index]}`);
    
    const logo = post.logo || "https://via.placeholder.com/80";
    const title = post.title.rendered;
    const popularity = post.popularity || 0;
    const link = post.link;

    podiumItem.querySelector('.podium-logo').src = logo;
    podiumItem.querySelector('.podium-logo').alt = title;
    podiumItem.querySelector('.podium-name').textContent = title;
    podiumItem.querySelector('.podium-fill').style.width = popularity + '%';
    podiumItem.querySelector('.podium-percent').textContent = popularity + '%';
    
    // Make clickable
    podiumItem.style.cursor = 'pointer';
    podiumItem.onclick = () => window.location.href = link;

    // Animate bars
    setTimeout(() => {
      podiumItem.querySelector('.podium-fill').style.width = popularity + '%';
    }, 100 * (index + 1));
  });
}

// Render Popularity Distribution Chart
function renderPopularityChart(posts) {
  const chartContainer = document.getElementById("chart-container");
  
  // Create ranges: 0-20, 21-40, 41-60, 61-80, 81-100
  const ranges = [
    { label: "0-20%", min: 0, max: 20, count: 0 },
    { label: "21-40%", min: 21, max: 40, count: 0 },
    { label: "41-60%", min: 41, max: 60, count: 0 },
    { label: "61-80%", min: 61, max: 80, count: 0 },
    { label: "81-100%", min: 81, max: 100, count: 0 }
  ];

  // Count posts in each range
  posts.forEach(p => {
    const pop = p.popularity || 0;
    const range = ranges.find(r => pop >= r.min && pop <= r.max);
    if (range) range.count++;
  });

  // Find max count for scaling
  const maxCount = Math.max(...ranges.map(r => r.count), 1);

  // Generate chart bars
  const barsHTML = ranges
    .map(r => {
      const heightPercent = (r.count / maxCount) * 100;
      return `
        <div class="chart-bar-wrapper">
          <div class="chart-bar" style="height: ${heightPercent}%">
            <span class="bar-count">${r.count}</span>
          </div>
          <span class="bar-label">${r.label}</span>
        </div>
      `;
    })
    .join("");

  chartContainer.innerHTML = barsHTML;

  // Animate bars
  setTimeout(() => {
    document.querySelectorAll('.chart-bar').forEach((bar, i) => {
      setTimeout(() => {
        bar.style.opacity = '1';
        bar.style.transform = 'scaleY(1)';
      }, i * 100);
    });
  }, 200);
}
  renderBannerSection();
  renderContentTop();
  renderContentBottom();
  renderRelatedCate();
  renderStatsInsights();
});