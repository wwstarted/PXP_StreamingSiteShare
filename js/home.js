document.addEventListener("DOMContentLoaded", async () => {
  const bannerContainer = document.querySelector("#banner-carousel");

  if (!bannerContainer) return;

  try {
    const res = await fetch(
      "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/post_item?per_page=100"
    );
    const items = await res.json();

    console.log("All post items:", items);

    // Random shuffle
    const shuffled = items.sort(() => Math.random() - 0.5);

    // Lấy 4 items đầu tiên
    const randomFour = shuffled.slice(0, 4);

    randomFour.forEach((item) => {
      const meta = item.meta || {};
      const image = meta.bgr_image || "";
      const postLink = meta.post_link || "#";
      const detailLink = item.link || "#";
      const title = item.title.rendered || "No title";

      const itemHTML = `
        <div class="carousel-item" onclick="window.location.href='${detailLink}';" style="cursor: pointer;">
          <img class="carousel-image" src="${image}" alt="${title}">
          <button 
            class="btn carousel-btn" 
            onclick="event.stopPropagation(); window.open('${postLink}', '_blank');"
          >
            Visit Site
            <i class="carousel-btn-icon fa-solid fa-angles-right"></i>
          </button>
        </div>
      `;
      
      bannerContainer.insertAdjacentHTML("beforeend", itemHTML);
    });

  } catch (error) {
    console.error("Lỗi khi tải post items:", error);
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
    const res = await fetch(
      `${API_BASE}/${endpoint}?page=${page}&per_page=${perPage}`
    );
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
      fetchAll("post_item"),
    ]);

    console.log("Categories:", cates);
    console.log("Posts:", posts);

    renderCategories(cates, posts);
  } catch (err) {
    console.error("Lỗi khi fetch dữ liệu:", err);
  }
}

function renderCategories(cates, posts) {
  const container = document.querySelector(".categories-container-home");
  if (!container) return;
  container.innerHTML = "";

  const visibleCates = cates.filter((cate) => {
    const v = cate.meta?._cate_post_visible;
    return v === "1" || v === 1 || v === true;
  });

  console.log("Visible categories:", visibleCates);

  visibleCates.forEach((cate) => {
    const cateId = cate.id;
    const meta = cate.meta || {};

    const cateThumbnail = meta.thumbnail || "";
    const shortDesc = meta.short_desc || "";
    const cateTitle = cate.title?.rendered || "No title";

    const catePosts = posts
      .filter((p) => {
        const ids = p.meta?.id_cate_post;
        return Array.isArray(ids) && ids.includes(cateId);
      })
      .sort((a, b) => (a.meta?.top || 0) - (b.meta?.top || 0));

    const displayPosts = catePosts.slice(0, 6);

    const postListHTML =
      displayPosts.length > 0
        ? displayPosts
            .map(
              (post, index) => `
        <a href="${post.link}" style="text-decoration: none; color: inherit;">
    <li>
        <p class="features-list-top">${index + 1}</p>
        <img class="features-list-logo-image" src="${post.meta?.logo || ""}" alt="${post.title.rendered}" />

        <p class="text-line features-list-name">${post.title.rendered}</p>
    </li>
</a>
      `
            )
            .join("")
        : `<li>No posts yet.</li>`;

    const lastThreePosts = catePosts.slice(-3);

    const lastThreeLogosHTML = lastThreePosts
      .map(
        (post) => `
        <a href="${post.link}" style="text-decoration: none; color: inherit;">
      <img class="footer-logo-preview"
        src="${post.meta?.logo || ""}"
        alt="${post.title.rendered}" />
        </a>
    `
      )
      .join("");

    const totalItems = catePosts.length;

    const cardHTML = `
      <div class="card">

        <!-- HEADER -->
        <div class="card-header">
          <div class="card-icon">
            <img class="card-icon-image"
              src="${cateThumbnail}"
              alt="icon ${cateTitle}" />
          </div>

          <div class="text-line card-title">
            <a class="card-title-link" href="#">${cateTitle}</a>
            <div class="card-tag">
              <span class="card-tag-cate">TOP Popular in VietNam</span>
            </div>
          </div>
        </div>

        <p class="text-line card-description">${shortDesc}</p>

        <!-- LIST -->
        <ul class="features-list">
          ${postListHTML}
        </ul>

        <!-- FOOTER -->
        <div class="card-footer">
          <a href="${cate.link}" class="visit-btn">
            <span>Load ${totalItems} sites</span>
            <i class="fa-solid fa-chevron-right footer-arrow-icon"></i>
          </a>

          <div class="footer-logos">
            ${lastThreeLogosHTML}
          </div>
        </div>

      </div>
    `;

    container.insertAdjacentHTML("beforeend", cardHTML);
  });
}

fetchData();

// /** =========banner-slide==========  */
// document.addEventListener("DOMContentLoaded", async () => {
//   const bannerContainer = document.querySelector("#banner-slide-home");

//   try {
//     const cateRes = await fetch(`${API_BASE}/post_item?per_page=5`);
//     const cate = await cateRes.json();

//     cate.forEach((banner) => {
//         const meta = banner.meta || {};
//         const image = meta.image || "";
//         const title = banner?.title?.rendered || "No Title";

//         const bannerHTML = `
//           <div class="banner-card">
//             <img
//               src="${image}"
//               alt="${title}"
//               class="banner-card-image"
//             />
//             <a href="${WP_HOME}/detailscate/?post_id=${banner.id}"  class="banner-card-btn">${title}</a>
//           </div>
//         `;
//         bannerContainer.insertAdjacentHTML("beforeend", bannerHTML);
//       });

//   } catch (error) {
//     console.error("Lỗi khi tải banner:", error);
//   }
// });

/** =========Cars Blogs==========  */
// document.addEventListener("DOMContentLoaded", async () => {
//   const bannerContainer = document.querySelector("#cars-blogs-home");

//   try {
//     const res = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/cars_blog?per_page=3");
//     const banners = await res.json();

//     banners.forEach((banner) => {
//         const meta = banner.meta || {};
//         const blog_desc = meta.blog_desc || "";
//         const title = banner?.title?.rendered || "Banner";

//         const bannerHTML = `
//         <section class="info-section">
//         <div>
//           <div class="info-header">
//             <h2>${title}</h2>
//             <div class="info-icons">
//               <span>🌟</span>
//               <span>🏆</span>
//             </div>
//           </div>
//           <div class="info-content">
//             <p>
//               ${blog_desc}
//             </p>
//             <div class="fade-overlay"></div>
//           </div>
//           <div class="btn-container">
//             <button class="show-more" onclick="toggleContent(this)">
//               <span class="text">Read More</span>
//               <span class="icon"><i class="fa-solid fa-angles-down"></i></span>
//             </button>
//           </div>
//         </div>
//         </section>
//         `;
//         bannerContainer.insertAdjacentHTML("beforeend", bannerHTML);
//       });

//   } catch (error) {
//     console.error("Lỗi khi tải banner:", error);
//   }
// });

/** Blog Section */
document.addEventListener("DOMContentLoaded", async () => {
  const bannerContainer = document.querySelector("#section-blog-home");
  
  if (!bannerContainer) return;

  try {
    // Fetch blogs data
    const res = await fetch(
      "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blogs?per_page=100"
    );
    const blogs = await res.json();

    // Filter: Chỉ lấy blogs có _blogs_visible = "1"
    const visibleBlogs = blogs.filter((blog) => {
      const isVisible = blog.meta?._blogs_visible;
      return isVisible === "1" || isVisible === true || isVisible === 1;
    });

    console.log("Visible blogs:", visibleBlogs);

    // Lấy 3 blogs đầu tiên để hiển thị
    const displayBlogs = visibleBlogs.slice(0, 3);

    // Render từng blog
    displayBlogs.forEach((blog) => {
      const meta = blog.meta || {};
      const title = blog?.title?.rendered || "No title";
      const image = meta.bg_thumbnail || "";
      const desc = meta.bg_short_desc || "No description";
      
      // Lấy author info từ REST API response (đã được expose từ PHP)
      const author = blog.author_name || "Unknown Author";
      const author_logo = blog.author_avatar || "";
      
      // Format date
      const date = formatDate(blog.date);

      const blogHTML = `
        <a href="${blog.link}" class="blog-card">
          <div class="blog-image">
            <img src="${image}" alt="${title}" />
          </div>
          <div class="blog-content">
            <h3 class="text-line blog-title">${title}</h3>
            <p class="text-line blog-description">${desc}</p>
            <div class="blog-meta">
              <img class="blog-meta-avatar" src="${author_logo}" alt="${author}" />
              <span>${author} | ${date}</span>
            </div>
            <span class="read-more">
              <span>Read more</span>
              <i style="font-size: 10px" class="fa-solid fa-chevron-right"></i>
            </span>
          </div>
        </a>
      `;
      
      bannerContainer.insertAdjacentHTML("beforeend", blogHTML);
    });

  } catch (error) {
    console.error("Lỗi khi tải blogs:", error);
  }
});

// Helper function: Format date
function formatDate(dateString) {
  if (!dateString) return "No date";
  
  const date = new Date(dateString);
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  
  return date.toLocaleDateString('en-US', options);
}