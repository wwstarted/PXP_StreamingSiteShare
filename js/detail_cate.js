document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";
  const WP_HOME = window.WP_HOME;
  let sharedPostId = null;

  // ---------- Helpers ----------
  function parseMaybeJson(val) {
    if (val === undefined || val === null) return null;
    if (Array.isArray(val)) return val;
    if (typeof val === "string") {
      try {
        const t = val.trim();
        if ((t.startsWith("[") && t.endsWith("]")) || (t.startsWith("{") && t.endsWith("}"))) {
          return JSON.parse(t);
        }
        // comma separated fallback
        if (t.includes(",")) return t.split(",").map(s => s.trim()).filter(Boolean);
        if (t === "") return null;
      } catch (e) {
        return val;
      }
    }
    return val;
  }

  function toNumberArray(value) {
    if (!value) return [];
    const parsed = parseMaybeJson(value);
    if (Array.isArray(parsed)) {
      return parsed.map(v => {
        if (typeof v === "number") return v;
        const n = parseInt(String(v).trim(), 10);
        return isNaN(n) ? null : n;
      }).filter(Boolean);
    }
    // if string
    if (typeof parsed === "string") {
      return parsed.split(",").map(s => {
        const n = parseInt(s.trim(), 10);
        return isNaN(n) ? null : n;
      }).filter(Boolean);
    }
    return [];
  }

  function arraysIntersect(arrA, arrB) {
    if (!Array.isArray(arrA) || !Array.isArray(arrB)) return false;
    const setA = new Set(arrA.map(String));
    return arrB.some(b => setA.has(String(b)));
  }

  // ---------- get slug & post id ----------
  async function getSlugFromPath() {
    const parts = location.pathname.split("/").filter(Boolean);
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
      const res = await fetch(`${API_BASE}/post_item?slug=${encodeURIComponent(slug)}`);
      const data = await res.json();
      if (Array.isArray(data) && data.length > 0) {
        sharedPostId = data[0].id;
        return sharedPostId;
      } else {
        console.error("Không tìm thấy post với slug:", slug);
        return null;
      }
    } catch (err) {
      console.error("Lỗi khi fetch post by slug:", err);
      return null;
    }
  }

  // ---------- UI events (unchanged) ----------
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

  // ---------- main ----------
  const postId = await getSharedPostId();
  if (!postId) {
    console.error("Không thể lấy Post ID. Dừng render.");
    return;
  }

  // Fetch current post ONCE and reuse
  let currentPost = null;
  try {
    const res = await fetch(`${API_BASE}/post_item/${postId}`);
    currentPost = await res.json();
  } catch (err) {
    console.error("Lỗi khi fetch current post:", err);
    return;
  }

  // ---------- SECTION 1: Top Content ----------
  try {
    const topContentSection = document.querySelector("#top-content-section");
    if (topContentSection) {
      const postTitle = currentPost?.title?.rendered || "No title";
      const postMeta = currentPost?.meta || {};
      const postLogo = postMeta.logo || "";
      const postLink = postMeta.post_link || "";

      topContentSection.innerHTML = `
        <div class="top-content-logo">
          <img class="top-content-logo-img" src="${postLogo}" alt="${postTitle}" />
        </div>
        <div class="site-info">
          <h2>${postTitle}</h2>
          <a href="${postLink}">${postLink || "#"}</a>
          <div class="stars">★★★★★</div>
        </div>
      `;
    }
  } catch (err) {
    console.error("Lỗi khi render top content:", err);
  }

  // ---------- SECTION 2: Background ----------
  try {
    const bgImage = currentPost?.meta?.bgr_image ||
      "http://localhost/PXP_SSW/wordpress/wp-content/themes/yourtheme/images/image_bgr.jpeg";
    const heroWrapper = document.querySelector(".hero-wrapper");
    if (heroWrapper) {
      heroWrapper.style.background = `url('${bgImage}') center/cover no-repeat`;
      heroWrapper.style.transition = "background 0.4s ease-in-out";
    }
  } catch (err) {
    console.error("Lỗi khi render background:", err);
  }

  // ---------- SECTION 3: Left Content ----------
  try {
    const contentleft = document.querySelector("#content-left");
    if (contentleft) {
      const postTitle = currentPost?.title?.rendered || "No title";
      const postDesc = currentPost?.meta?.desc || "";
      contentleft.innerHTML = `
        <h3>${postTitle}</h3>
        <p>${postDesc}</p>
      `;
    }
  } catch (err) {
    console.error("Lỗi khi render left content:", err);
  }

  // ---------- SECTION 4: Good & Bad ----------
  try {
    const contentgb = document.querySelector("#goodabad");
    if (contentgb) {
      const likesRaw = currentPost?.meta?.likes || "[]";
      const hatesRaw = currentPost?.meta?.hates || "[]";
      const likes = parseMaybeJson(likesRaw) || [];
      const hates = parseMaybeJson(hatesRaw) || [];

      const likeHTML = Array.isArray(likes) ? likes.map(item => `<li>✅ ${item}</li>`).join("") : "";
      const hateHTML = Array.isArray(hates) ? hates.map(item => `<li>❌ ${item}</li>`).join("") : "";

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
    }
  } catch (err) {
    console.error("Lỗi when render good/bad:", err);
  }

  // ---------- SECTION 5: Related Posts (same category) ----------
  try {
    const detailsContainer = document.querySelector("#details-container");
    if (!detailsContainer) {
      console.warn("Không tìm thấy #details-container");
    } else {
      // Lấy mảng category id của post hiện tại
      const currentCateIds = toNumberArray(currentPost?.meta?.id_cate_post);
      if (!currentCateIds.length) {
        detailsContainer.innerHTML = `<p class="no-related">No related posts found.</p>`;
      } else {
        // Fetch tất cả post_item (tăng per_page nếu cần)
        const perPage = 100; // nếu site có >100 posts tăng số này
        const allRes = await fetch(`${API_BASE}/post_item?per_page=${perPage}`);
        const allPosts = await allRes.json();

        const relatedPosts = (Array.isArray(allPosts) ? allPosts : [])
          .filter(p => {
            const pCateIds = toNumberArray(p?.meta?.id_cate_post);
            // kiểm tra giao nhau giữa currentCateIds và pCateIds
            return arraysIntersect(currentCateIds, pCateIds) && String(p.id) !== String(postId);
          });

        if (!relatedPosts.length) {
          detailsContainer.innerHTML = `<p class="no-related">No related posts found.</p>`;
        } else {
          // render each related with image / title / link (layout 3 thành phần)
          relatedPosts.forEach(post => {
            const meta = post?.meta || {};
            const image = meta.image || meta.logo || "";
            const title = post?.title?.rendered || "No Title";
            const link = post?.link || "#";

            const bannerHTML = `
              <div class="banner-card">
                <img src="${image}" alt="${title}" class="banner-card-image" />
                <a href="${link}" class="banner-card-btn">${title}</a>
              </div>
            `;
            detailsContainer.insertAdjacentHTML("beforeend", bannerHTML);
          });
        }
      }
    }
  } catch (err) {
    console.error("Lỗi fetch related posts:", err);
  }

  // ---------- SECTION 6: Breadcrumb ----------
  try {
    const breadcrumb = document.querySelector(".breadcrumb");
    if (breadcrumb) {
      const title = currentPost?.title?.rendered || "Banner";
      const bannerHTML = `
        <a href="${WP_HOME}"><i class="fa-solid fa-house"></i> Streaming Sites</a> /
        <a href="${WP_HOME}/categories/">Category</a> /
        <span>${title}</span>
      `;
      breadcrumb.insertAdjacentHTML("beforeend", bannerHTML);
    }
  } catch (err) {
    console.error("Lỗi khi tải breadcrumb:", err);
  }
});
