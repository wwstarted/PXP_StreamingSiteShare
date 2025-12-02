document.addEventListener("DOMContentLoaded", async () => {
  const bannerContainer = document.querySelector("#banner-carousel");

  try {
    const res = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/banner?per_page=100");
    const banners = await res.json();

    const shuffled = banners.sort(() => Math.random() - 0.5);

    const randomFour = shuffled.slice(0, 4);

    randomFour.forEach((banner) => {
        const meta = banner.meta || {};
        const image = meta.image || "";
        const link = meta.link || "#";
        const title = meta.title || banner.title.rendered || "Banner";

        const bannerHTML = `
          <div class="carousel-item">
            <img class="carousel-image" src="${image}" alt="${title}">
            <button 
              class="btn carousel-btn" 
              onclick="window.open('${link}', '_blank')"
            >
              Get ${title}
              <i class="carousel-btn-icon fa-solid fa-angles-right"></i>
            </button>
          </div>
        `;
        bannerContainer.insertAdjacentHTML("beforeend", bannerHTML);
      });

  } catch (error) {
    console.error("Lỗi khi tải banner:", error);
  }
});



// ==========================
const prevBtn = document.querySelector(".banner-section-prev");
const nextBtn = document.querySelector(".banner-section-back");
const slider = document.querySelector(".banner-section-slide");

if (prevBtn && nextBtn && slider) {
  prevBtn.addEventListener("click", () => {
    slider.scrollBy({
      left: -320,
      behavior: "smooth",
    });
  });

  nextBtn.addEventListener("click", () => {
    slider.scrollBy({
      left: 320,
      behavior: "smooth",
    });
  });
}


/*   READ MORE  */
// ==========================
function toggleContent(button) {
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
}



/** Render Cart-Iteam */
const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";

async function fetchAll(endpoint, perPage = 50) {
  let page = 1;
  let allData = [];
  while (true) {
    const res = await fetch(`${API_BASE}/${endpoint}?page=${page}&per_page=${perPage}`);
    if (!res.ok) break;
    const data = await res.json();
    allData = [...allData, ...data];
    if (data.length < perPage) break;
    page++;
  }
  return allData;
}

async function fetchData() {
  try {
    const [cates, posts] = await Promise.all([
      fetchAll("cate_post"),
      fetchAll("post_item")
    ]);

    console.log("Categories:", cates);
    console.log("Posts:", posts);

    renderCategories(cates, posts);
  } catch (err) {
    console.error("Lỗi khi fetch dữ liệu:", err);
  }
}

function renderCategories(cates, posts) {
  const container = document.querySelector(".categories-container");
  if (!container) return;
  container.innerHTML = "";

  cates.forEach(cate => {

    const cate_id = cate.id;
    const meta = cate.meta || {};
    const cateThumbnail = meta.thumbnail || "";
    const shortDesc = meta.short_desc || "";
    const cateTitle = cate.title.rendered || "No title";

  
    const catePosts = posts
      .filter(p => p.meta?.id_cate == cate.id)
      .sort((a, b) => (a.meta?.top || 0) - (b.meta?.top || 0));

    const postListHTML = catePosts
      .map(post => `
        <li>
          <p class="features-list-top">${post.meta?.top || ""}</p>
          <img
            class="features-list-logo-image"
            src="${post.meta?.logo || ""}"
            alt="${post.title.rendered}"
          />
          <p class="text-line features-list-name">${post.title.rendered}</p>
        </li>
      `)
      .join("");

    const cardHTML = `
      <div class="card">
        <div class="card-header">
          <div class="card-icon">
            <img
              class="card-icon-image"
              src="${cateThumbnail}"
              alt="icon ${cateTitle}"
            />
          </div>
          <div class="text-line card-title">
            <a class="card-title-link" href="#">${cateTitle}</a>
            <div class="card-tag">
              <span class="card-tag-cate">TOP Popular in VietNam</span>
            </div>
          </div>
        </div>

        <p class="text-line card-description">${shortDesc}</p>

        <ul class="features-list">
          ${postListHTML || "<li>No posts yet.</li>"}
        </ul>

        <div class="card-footer">
          <a href="${WP_HOME}/categories?cate_id=${cate.id}" class="visit-btn">
            View all <i class="fa-solid fa-chevron-right"></i>
          </a>
        </div>
      </div>
    `;

    container.insertAdjacentHTML("beforeend", cardHTML);
  });
}

fetchData();




/** =========banner-slide==========  */
document.addEventListener("DOMContentLoaded", async () => {
  const bannerContainer = document.querySelector("#banner-slide");

  try {
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
            <a href="${WP_HOME}/detailscate/?post_id=${banner.id}"  class="banner-card-btn">${title}</a>
          </div>
        `;
        bannerContainer.insertAdjacentHTML("beforeend", bannerHTML);
      });

  } catch (error) {
    console.error("Lỗi khi tải banner:", error);
  }
});




/** =========Cars Blogs==========  */
document.addEventListener("DOMContentLoaded", async () => {
  const bannerContainer = document.querySelector("#cars-blogs");

  try {
    const res = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/cars_blog?per_page=3");
    const banners = await res.json();

    banners.forEach((banner) => {
        const meta = banner.meta || {};
        const blog_desc = meta.blog_desc || "";
        const title = banner?.title?.rendered || "Banner";


        const bannerHTML = `
        <section class="info-section">
        <div>
          <div class="info-header">
            <h2>${title}</h2>
            <div class="info-icons">
              <span>🌟</span>
              <span>🏆</span>
            </div>
          </div>
          <div class="info-content">
            <p>
              ${blog_desc}
            </p>
            <div class="fade-overlay"></div>
          </div>
          <div class="btn-container">
            <button class="show-more" onclick="toggleContent(this)">
              <span class="text">Read More</span>
              <span class="icon"><i class="fa-solid fa-angles-down"></i></span>
            </button>
          </div>
        </div>
        </section>
        `;
        bannerContainer.insertAdjacentHTML("beforeend", bannerHTML);
      });

  } catch (error) {
    console.error("Lỗi khi tải banner:", error);
  }
});


/** Blog Section */

document.addEventListener("DOMContentLoaded", async () => {
  const bannerContainer = document.querySelector("#section-blog");

  try {
    const res = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/post_item?per_page=3");
    const banners = await res.json();

    banners.forEach((banner) => {
        const meta = banner.meta || {};
        const title = banner?.title?.rendered || "Banner";
        const image = meta.image || "";
        const desc = meta.desc || "Description";
        const author_logo = meta.author_logo || "";
        const author = meta.author || "Author";
        const date = meta.date || "Date";

        const bannerHTML = `
          <div class="blog-card">
              <div
                class="blog-image"
              >
                <img
                    src="${image}"
                    alt=""
                  />
              </div>
              <div class="blog-content">
                <h3 class="text-line blog-title">${title}</h3>
                <p class="text-line blog-description">
                 ${desc}
                </p>
                <div class="blog-meta">
                  <img
                    class="blog-meta-avatar"
                    src="${author_logo}"
                    alt=""
                  />
                  <span>${author} | ${date}</span>
                </div>
                <a href="${WP_HOME}/detailscate/?post_id=${banner.id}" class="read-more"
                  ><span>Read more</span>
                  <i style="font-size: 10px" class="fa-solid fa-chevron-right"></i
                ></a>
              </div>
            </div>
        `;
        bannerContainer.insertAdjacentHTML("beforeend", bannerHTML);
      });

  } catch (error) {
    console.error("Lỗi khi tải banner:", error);
  }
});





