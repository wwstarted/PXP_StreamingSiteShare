document.addEventListener("DOMContentLoaded", async () => {


const container = document.querySelector(".brand-container");
const nextBtn = document.querySelector(".next-btn");
const prevBtn = document.querySelector(".prev-btn");

nextBtn.addEventListener("click", () => {
  container.scrollBy({ left: 300, behavior: "smooth" });
});

prevBtn.addEventListener("click", () => {
  container.scrollBy({ left: -300, behavior: "smooth" });
});

  const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";
  let sharedPostId = null;

  async function getSharedPostId() {
    if (sharedPostId) return sharedPostId;

    const params = new URLSearchParams(window.location.search);
    let postId = params.get("post_id");

    sharedPostId = postId;
    console.log("✅ Post ID dùng chung:", sharedPostId);
    return sharedPostId;
  }

  const postId = await getSharedPostId();

  /** fetch Image Post */

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
            alt="FX Networks"
          />
        </div>
        <div class="site-info">
          <h2>${postTitle}</h2>
          <a href="${postLink}">https://www.carspassion.com</a>
          <div class="stars">★★★★★</div>
        </div>
    `;
  } catch (error) {
    console.error("Lỗi khi fetch banner:", error);
  }

  /** fetch bgr_image */

    async function renderHeroBackground() {

    try {
      // Gọi API lấy post theo ID
      const res = await fetch(`${API_BASE}/post_item/${postId}`);
      const post = await res.json();

      // Lấy custom field bgr_image
      const bgImage =
        post.meta?.bgr_image ||
        "http://localhost/PXP_SSW/wordpress/wp-content/themes/yourtheme/images/image_bgr.jpeg"; // fallback ảnh mặc định

      // Set background cho hero-wrapper
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

  /** =========================== fetch leftcontent================ */
  try {
    const contentleft = document.querySelector("#content-left");
    const postRes = await fetch(`${API_BASE}/post_item/${postId}`);
    const post = await postRes.json();

    const postTitle = post.title.rendered || "No title";
    const postMeta = post.meta || {};
    const postDesc = postMeta.desc || "";

    contentleft.innerHTML = `
       <h3>${postTitle}</h3>
        <p>
            ${postDesc}
        </p>
    `;
  } catch (error) {
    console.error("Lỗi khi fetch banner:", error);
  }

  /** ==================fetch right content ================ */
   try {
    const contentgb = document.querySelector("#goodabad");
    const postRes = await fetch(`${API_BASE}/post_item/${postId}`);
    const post = await postRes.json();

    const postTitle = post.title.rendered || "No title";
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
    console.error("Lỗi khi fetch banner:", error);
  }

  /** ===============================fetch brand-container ================= */

  try {
    const detailsContainer = document.querySelector("#details-container");
    const cateRes = await fetch(`${API_BASE}/post_item?per_page=5`);
    const cate = await cateRes.json();

    const relatedPost = cate.filter(c => String(c.id) !== String(postId));

    relatedPost.forEach((banner) => {
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
        detailsContainer.insertAdjacentHTML("beforeend", bannerHTML);
      });
  } catch (error) {
    console.error("Lỗi fetch content top:", error);
  }

  const breadcrumb = document.querySelector(".breadcrumb");
    try {
        const res = await fetch(`http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/post_item/${postId}`);
        const blog = await res.json();
        
            const title = blog?.title?.rendered || "Banner";

            const bannerHTML = `
                <a href="http://localhost/PXP_SSW/wordpress/"><i class="fa-solid fa-house"></i> Streaming Sites</a> /
                <a href="http://localhost/PXP_SSW/wordpress/categories/">Category</a> /
                <span>${title}</span>
            `;

            breadcrumb.insertAdjacentHTML("beforeend", bannerHTML);
        
    } catch (error) {
        console.error("Lỗi khi tải banner:", error);
    }

});
