document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";
  let sharedCateId = null;

  /* ====================== UI SLIDER & BUTTON ====================== */
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

  /* ====================== FETCH & RENDER ====================== */

/* ================= get CATE_ID ============*/
  async function getSharedCateId() {
    if (sharedCateId) return sharedCateId;

    const params = new URLSearchParams(window.location.search);
    let cateId = params.get("cate_id");

    if (!cateId) {
      const allCateRes = await fetch(`${API_BASE}/cate_post?per_page=100`);
      const allCategories = await allCateRes.json();

      if (!allCategories.length) throw new Error("Không có category nào trong API");
      const randomCate = allCategories[Math.floor(Math.random() * allCategories.length)];
      cateId = randomCate.id;
    }

    sharedCateId = cateId;
    console.log("Cate ID dùng chung:", sharedCateId);
    return sharedCateId;
  }



  const cateId = await getSharedCateId(); 
 

  /* ========== 1. Fetch banner ========== */
  try {
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
    console.error("Lỗi khi fetch banner:", error);
  }

  /* ========== 2. Fetch content top ========== */
  try {
    const rightContent = document.querySelector("#right_content_top");
    const cateRes = await fetch(`${API_BASE}/cate_post/${cateId}`);
    const cate = await cateRes.json();

    const title = cate?.title?.rendered || "Banner";
    const bannerHTML = `
      <h2>${title}</h2>
      <div class="table-header">
        <span></span>
        <span></span>
        <span style="margin-left: 10px"
          >Name<i style="font-size: 10px; margin-left: 3px" class="fa-solid fa-chevron-down"></i></span>
        <span style="margin-left: -10px"
          >Popularity<i style="font-size: 10px; margin-left: 3px" class="fa-solid fa-chevron-down"></i></span>
      </div>
    `;
    rightContent.insertAdjacentHTML("beforeend", bannerHTML);
  } catch (error) {
    console.error("Lỗi fetch content top:", error);
  }

  /* ========== 3. Fetch bottom content ========== */
  try {
    const rightContent = document.querySelector("#right_content_bottom");
    const cateRes = await fetch(`${API_BASE}/cate_post/${cateId}`);
    const cate = await cateRes.json();

    const postsRes = await fetch(`${API_BASE}/post_item?per_page=100`);
    let posts = await postsRes.json();

    posts = posts.filter(p => String(p.meta?.id_cate) === String(cateId));
    posts.sort((a, b) => (b.meta?.popularity || 0) - (a.meta?.popularity || 0));

    if (posts.length === 0) {
      rightContent.insertAdjacentHTML("beforeend", "<p>Không có bài viết nào.</p>");
      return;
    }

    const rowsHTML = posts.map((post, index) => {
      const popularity = parseInt(post.meta?.popularity || 0);
      const logo = post.meta?.logo || "https://via.placeholder.com/50";
      const title = post.title?.rendered || "Không có tiêu đề";

      return `
        <a href="http://localhost/PXP_SSW/wordpress/detailscate/?post_id=${post.id}" class="table-row">
          <span>${index + 1}</span>
          <img src="${logo}" alt="Logo" />
          <span>${title}</span>
          <div class="bar"><div class="fill" style="width: ${popularity}%"></div></div>
        </a>
      `;
    }).join("");

    rightContent.insertAdjacentHTML("beforeend", rowsHTML);

    const adsHTML1 = `
      <div class="ads">
              <a 
              href="https://www.porsche.com/international/models/718/" 
              target="_blank" 
              rel="noopener noreferrer"
              >
              <img
                src="https://images.unsplash.com/photo-1496200186974-4293800e2c20?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8bG9nb3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&q=60&w=600"
                alt="Advertisement"
              />
              </a>
      </div>
    `;
    rightContent.insertAdjacentHTML("beforeend", adsHTML1);

  } catch (error) {
    console.error("Lỗi fetch content bottom:", error);
  }


  /** fetch related  */

  const related = document.querySelector("#banner-slide");

  try {
    const res = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/banner");
    const banners = await res.json();

    banners.forEach((banner) => {
        const meta = banner.meta || {};
        const image = meta.image || "";
        const link = meta.link || "#";
        const title = meta.title || banner.title.rendered || "Banner";

        const bannerHTML = `
          <div class="banner-card">
            <img
              src="${image}"
              alt="${title}"
              class="banner-card-image"
            />
            <div class="banner-card-btn">${title}</div>
          </div>
        `;
        related.insertAdjacentHTML("beforeend", bannerHTML);
      });

  } catch (error) {
    console.error("Lỗi khi tải banner:", error);
  }

  /** ================= FETCH & RENDER RELATED CATEGORIES ================== */
const relatedContainer = document.querySelector(".left_content");

async function fetchPostsByCategory(cateId, limit = 5) {
  const res = await fetch(`${API_BASE}/post_item?per_page=100`); // lấy tất cả post trước
  const allPosts = await res.json();
  const posts = allPosts
    .filter(p => String(p.meta?.id_cate) === String(cateId))
    .slice(0, limit); // lấy limit bài đầu tiên
  return posts;
}

try {
  // Lấy tất cả cate trừ cate hiện tại
  const allCateRes = await fetch(`${API_BASE}/cate_post?per_page=100`);
  const allCategories = await allCateRes.json();
  const relatedCates = allCategories.filter(c => String(c.id) !== String(cateId));

  // render mỗi cate
  for (const cate of relatedCates) {
    const cateMeta = cate.meta || {};
    const cateLogo = cateMeta.thumbnail || "https://via.placeholder.com/80";
    const cateTitle = cate.title?.rendered || "No Title";

    // Lấy 5 post đầu tiên của cate này
    const posts = await fetchPostsByCategory(cate.id, 5);
    const res = await fetch(`${API_BASE}/post_item?per_page=100`); // lấy tất cả post trước
    const allPosts = await res.json();

    const miniLogosHTML = posts.map(p => {
      const logo = p.meta?.logo || "https://via.placeholder.com/50";
      return `<img src="${logo}" alt="icon" />`;
    }).join("");

    const totalPosts = allPosts.filter(p => String(p.meta?.id_cate) === String(cate.id)).length;
    const remaining = totalPosts - posts.length;

    const remainingHTML = remaining > 0 ? `<a href="categories?cate_id=${cate.id}" class="visit-btn-cate">+${remaining}</a>` : "";

    const relatedHTML = `
      <div class="related-item">
        <img src="${cateLogo}" alt="Logo" />
        <div class="info">
          <h3>${cateTitle}</h3>
          <div class="mini-logos">
            ${miniLogosHTML}
            ${remainingHTML}
          </div>
        </div>
      </div>
    `;

    relatedContainer.insertAdjacentHTML("beforeend", relatedHTML);

    
  }
  const adsHTML = `
    <div class="ads-side">
      <a 
      href="https://www.porsche.com/international/models/718/" 
      target="_blank" 
      rel="noopener noreferrer"
      >
      <img
        src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?auto=format&fit=crop&q=60&w=600"
        alt="Ads"
      />
      <a/>
    </div>
  `;
  relatedContainer.insertAdjacentHTML("beforeend", adsHTML);

} catch (error) {
  console.error("Lỗi khi fetch related categories:", error);
}


  try {
    const brandContainer = document.querySelector("#brand-container");
    const cateRes = await fetch(`${API_BASE}/post_item?per_page=5`);
    const cate = await cateRes.json();

    cate.forEach((banner) => {
        const meta = banner.meta || {};
        const image = meta.image || "";
        const title = banner?.title?.rendered || "No Title";

        const bannerHTML = `
          <div class="banner-card">
            <img
              src="${image}"
              alt="${title}"
              class="banner-card-image"
            />
            <a href="http://localhost/PXP_SSW/wordpress/detailscate/?post_id=${banner.id}"  class="banner-card-btn">${title}</a>
          </div>
        `;
        brandContainer.insertAdjacentHTML("beforeend", bannerHTML);
      });
  } catch (error) {
    console.error("Lỗi fetch content top:", error);
  }

});



