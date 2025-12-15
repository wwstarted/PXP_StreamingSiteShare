document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "https://streamingsite.proxyflowpxp.com/wp-json/wp/v2";
  const WP_HOME = window.WP_HOME;
  let sharedPostId = null;

  function parseMaybeJson(val) {
    if (val === undefined || val === null) return null;
    if (Array.isArray(val)) return val;
    if (typeof val === "string") {
      try {
        const t = val.trim();
        if ((t.startsWith("[") && t.endsWith("]")) || (t.startsWith("{") && t.endsWith("}"))) {
          return JSON.parse(t);
        }
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
      const res = await fetch(`${API_BASE}/posts?slug=${encodeURIComponent(slug)}`);
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

  function initReadingProgress() {
    const contentLeft = document.querySelector(".left-content");
    if (!contentLeft) return;

    contentLeft.addEventListener("scroll", () => {
      const scrollTop = contentLeft.scrollTop;
      const scrollHeight = contentLeft.scrollHeight - contentLeft.clientHeight;
      const scrollPercent = (scrollTop / scrollHeight) * 100;
      contentLeft.style.setProperty('--scroll-progress', `${scrollPercent}%`);
    });
  }

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

  const postId = await getSharedPostId();
  if (!postId) {
    console.error("Không thể lấy Post ID. Dừng render.");
    return;
  }

  let currentPost = null;
  try {
    // ✅ Chuyển sang endpoint posts
    const res = await fetch(`${API_BASE}/posts/${postId}`);
    currentPost = await res.json();
  } catch (err) {
    console.error("Lỗi khi fetch current post:", err);
    return;
  }

  // top content
  try {
    const topContentSection = document.querySelector("#top-content-section");
    if (topContentSection) {
      const postTitle = currentPost?.title?.rendered || "No title";
      // ✅ Lấy từ root level
      const postLogo = currentPost?.logo || "";
      const postLink = currentPost?.post_link || "";

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

  // =================== background ====================
  try {
    const bgImage = currentPost?.bgr_image ||
      "https://streamingsite.proxyflowpxp.com/wp-content/themes/yourtheme/images/image_bgr.jpeg";
    const heroWrapper = document.querySelector(".hero-wrapper");
    if (heroWrapper) {
      heroWrapper.style.background = `url('${bgImage}') center/cover no-repeat`;
      heroWrapper.style.transition = "background 0.4s ease-in-out";
    }
  } catch (err) {
    console.error("Lỗi khi render background:", err);
  }

  // ================= left-content =========================
  try {
    const contentleft = document.querySelector("#content-left");
    if (contentleft) {
      const postTitle = currentPost?.title?.rendered || "No title";
      // ✅ Dùng content mặc định của WP
      const postDesc = currentPost?.content?.rendered || "No description available.";
      // ✅ Lấy từ root level
      const likesRaw = currentPost?.likes || "[]";
      const hatesRaw = currentPost?.hates || "[]";
      const likes = parseMaybeJson(likesRaw) || [];
      const hates = parseMaybeJson(hatesRaw) || [];

      const likeHTML = Array.isArray(likes) && likes.length > 0
        ? likes.map(item => `<li>${item}</li>`).join("")
        : "<li>No likes listed.</li>";

      const hateHTML = Array.isArray(hates) && hates.length > 0
        ? hates.map(item => `<li>${item}</li>`).join("")
        : "<li>No dislikes listed.</li>";

      contentleft.innerHTML = `
        <div class="left-content-inner">
          <h3>${postTitle}</h3>
          <div>${postDesc}</div>
          
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
        </div>
      `;

      setTimeout(initReadingProgress, 100);
    }
  } catch (err) {
    console.error("Lỗi khi render left content:", err);
  }

  //  ==================== right slidebar =======================
  try {
    const contentgb = document.querySelector("#goodabad");
    if (contentgb) {
      // Static demo reviews data
      const demoReviews = [
        {
          name: "John Doe",
          initials: "JD",
          rating: 5,
          text: "Amazing streaming quality! The interface is super smooth and content library is huge. Definitely worth it!"
        },
        {
          name: "Sarah Miller",
          initials: "SM",
          rating: 4,
          text: "Great service overall. Fast loading times and good selection. Only issue is occasional buffering during peak hours."
        },
        {
          name: "Mike Johnson",
          initials: "MJ",
          rating: 5,
          text: "Best streaming platform I've used! Clean UI, no ads, and excellent customer support. Highly recommend!"
        },
        {
          name: "Emily Wilson",
          initials: "EW",
          rating: 4,
          text: "Solid platform with great features. Works perfectly on all my devices. Would give 5 stars if they had more international content."
        }
      ];

      // Generate star rating HTML
      function generateStars(rating) {
        let starsHTML = '';
        for (let i = 1; i <= 5; i++) {
          if (i <= rating) {
            starsHTML += '<span class="star">★</span>';
          } else {
            starsHTML += '<span class="star empty">★</span>';
          }
        }
        return starsHTML;
      }

      // Build reviews HTML
      const reviewsHTML = demoReviews.map(review => `
        <div class="review-card">
          <div class="review-header">
            <div class="review-avatar">${review.initials}</div>
            <div class="review-info">
              <p class="review-name">${review.name}</p>
              <div class="review-rating">
                ${generateStars(review.rating)}
              </div>
            </div>
          </div>
          <p class="review-text">${review.text}</p>
        </div>
      `).join('');

      // Render entire user reviews section
      contentgb.outerHTML = `
        <div class="user-reviews-section">
          <h3>User Reviews</h3>
          ${reviewsHTML}
        </div>
      `;
    }
  } catch (err) {
    console.error("Lỗi when render user reviews:", err);
  }

  // ======================= comment box ==============================
  try {
    const commentBox = document.querySelector(".comment-box");
    if (commentBox) {
      commentBox.innerHTML = `
        <h4>Leave a Review</h4>
        
        <div class="star-rating-picker">
          <label>Your Rating:</label>
          <div class="stars-input" id="starsInput">
            <button type="button" class="star-btn" data-rating="1">★</button>
            <button type="button" class="star-btn" data-rating="2">★</button>
            <button type="button" class="star-btn" data-rating="3">★</button>
            <button type="button" class="star-btn" data-rating="4">★</button>
            <button type="button" class="star-btn" data-rating="5">★</button>
          </div>
        </div>

        <textarea 
          id="commentTextarea" 
          placeholder="Share your experience with this streaming service..."
          maxlength="500"
        ></textarea>

        <a href="${WP_HOME}/404notfound" class="btn-submit" id="submitBtn">
          Submit Review
        </a>
      `;

      setTimeout(() => {
        const starsContainer = document.getElementById('starsInput');
        const starBtns = starsContainer?.querySelectorAll('.star-btn');
        let selectedRating = 0;

        if (starBtns) {
          starBtns.forEach(btn => {
            btn.addEventListener('click', function() {
              selectedRating = parseInt(this.dataset.rating);
              
              starBtns.forEach((star, index) => {
                if (index < selectedRating) {
                  star.classList.add('active');
                } else {
                  star.classList.remove('active');
                }
              });
            });

            btn.addEventListener('mouseenter', function() {
              const hoverRating = parseInt(this.dataset.rating);
              starBtns.forEach((star, index) => {
                if (index < hoverRating) {
                  star.style.color = '#fbbf24';
                }
              });
            });

            btn.addEventListener('mouseleave', function() {
              starBtns.forEach((star, index) => {
                if (index < selectedRating) {
                  star.style.color = '#fbbf24';
                } else {
                  star.style.color = 'rgba(251, 191, 36, 0.3)';
                }
              });
            });
          });
        }

        const submitBtn = document.getElementById('submitBtn');
        const textarea = document.getElementById('commentTextarea');
        
        if (submitBtn && textarea) {
          submitBtn.addEventListener('click', function(e) {
            const comment = textarea.value.trim();
            
            if (selectedRating === 0) {
              e.preventDefault();
              alert('Please select a rating (1-5 stars)!');
              return;
            }
            
            if (comment === '') {
              e.preventDefault();
              alert('Please write your review!');
              return;
            }

            if (comment.length < 10) {
              e.preventDefault();
              alert('Review must be at least 10 characters long!');
              return;
            }
            
            console.log('Rating:', selectedRating);
            console.log('Comment:', comment);
          });
        }
      }, 100);
    }
  } catch (err) {
    console.error("Lỗi when render comment box:", err);
  }

  // /============== related posts ====================
  try {
    const detailsContainer = document.querySelector("#details-container");
    if (!detailsContainer) {
      console.warn("Không tìm thấy #details-container");
    } else {
      // ✅ Get current post's category IDs từ root level
      const currentCateIds = currentPost?.categories || [];
      
      if (!currentCateIds.length) {
        detailsContainer.innerHTML = `
          <p style="text-align: center; color: rgba(255,255,255,0.5); padding: 40px 20px;">
            No related streaming sites found.
          </p>
        `;
      } else {
        // ✅ Fetch all posts từ endpoint mới
        const perPage = 100;
        const allRes = await fetch(`${API_BASE}/posts?per_page=${perPage}`);
        const allPosts = await allRes.json();

        // ✅ Filter related posts (same category, exclude current post)
        const relatedPosts = (Array.isArray(allPosts) ? allPosts : [])
          .filter(p => {
            const pCateIds = p?.categories || [];
            return arraysIntersect(currentCateIds, pCateIds) && String(p.id) !== String(postId);
          })
          .slice(0, 8); // Limit to 8 related posts

        if (!relatedPosts.length) {
          detailsContainer.innerHTML = `
            <p style="text-align: center; color: rgba(255,255,255,0.5); padding: 40px 20px;">
              No related streaming sites found.
            </p>
          `;
        } else {
          // Render each related post as detail stream card
          relatedPosts.forEach(post => {
            // ✅ Lấy data từ root level
            const image = post?.image || post?.bgr_image || "https://via.placeholder.com/400x200";
            const logo = post?.logo || "";
            const title = post?.title?.rendered || "No Title";
            const link = post?.link || "#";
            const popularity = post?.popularity || "";
            
            // Logo HTML - placeholder if no logo
            const logoHTML = logo 
              ? `<img class="detail-card-logo" src="${logo}" alt="${title}" />` 
              : `<div class="detail-card-logo-placeholder">
                   <i class="fa-solid fa-fire"></i>
                 </div>`;
            
            // Tags HTML
            const tagsHTML = `
              <div class="detail-card-tags">
                <span class="detail-tag">Similar</span>
                ${popularity ? `<span class="detail-tag">${popularity}%</span>` : ''}
              </div>
            `;
            
            // Build detail stream card
            const cardHTML = `
              <div class="detail-stream-card">
                <!-- Background Image -->
                <img src="${image}" class="detail-card-image" alt="${title}" />
                
                <!-- Gradient Overlay -->
                <div class="detail-card-overlay"></div>
                
                <!-- Glass Info Panel -->
                <div class="detail-card-info">
                  ${logoHTML}
                  
                  <h3 class="detail-card-title">${title}</h3>
                  
                  ${tagsHTML}
                  
                  <a href="${link}" class="detail-card-btn">
                    <span>View Details</span>
                    <i class="fa-solid fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            `;
            
            detailsContainer.insertAdjacentHTML("beforeend", cardHTML);
          });
        }
      }
    }
  } catch (err) {
    console.error("Lỗi fetch similar streaming sites:", err);
  }

  // ======================== breakcrumb=================================
try {
  const breadcrumbEl = document.querySelector(".breadcrumb");
  if (breadcrumbEl && currentPost) {
    
    // separator icon
    const sep = `<span class="breadcrumb-sep"><i class="fa-solid fa-chevron-right"></i></span>`;

    // Lấy category đầu tiên của bài viết
    const cateId = currentPost.categories?.[0] || null;
    let cateName = "";
    let cateSlug = "";

    if (cateId) {
      const resCate = await fetch(`${API_BASE}/categories/${cateId}`);
      const cateData = await resCate.json();
      cateName = cateData?.name || "";
      cateSlug = cateData?.slug || "";
    }

    // Build HTML
    breadcrumbEl.innerHTML = `
      <a href="${WP_HOME}">
        <i class="fa-solid fa-house"></i> Home
      </a>

      ${sep}

      <a href="${WP_HOME}/${cateSlug}">
        ${cateName}
      </a>

      ${sep}

      <span>${currentPost.title.rendered}</span>
    `;
  }
} catch (err) {
  console.error("Breadcrumb lỗi:", err);
}

});

document.addEventListener('DOMContentLoaded', function() {
  const starsContainer = document.getElementById('starsInput');
  const starBtns = starsContainer?.querySelectorAll('.star-btn');
  let selectedRating = 0;

  if (starBtns) {
    starBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        selectedRating = parseInt(this.dataset.rating);
        
        starBtns.forEach((star, index) => {
          if (index < selectedRating) {
            star.classList.add('active');
          } else {
            star.classList.remove('active');
          }
        });
      });

      btn.addEventListener('mouseenter', function() {
        const hoverRating = parseInt(this.dataset.rating);
        starBtns.forEach((star, index) => {
          if (index < hoverRating) {
            star.style.color = '#fbbf24';
          }
        });
      });

      btn.addEventListener('mouseleave', function() {
        starBtns.forEach((star, index) => {
          if (index < selectedRating) {
            star.style.color = '#fbbf24';
          } else {
            star.style.color = 'rgba(251, 191, 36, 0.3)';
          }
        });
      });
    });
  }

  const submitBtn = document.getElementById('submitBtn');
  const textarea = document.getElementById('commentTextarea');
  
  if (submitBtn && textarea) {
    submitBtn.addEventListener('click', function(e) {
      const comment = textarea.value.trim();
      
      if (selectedRating === 0) {
        e.preventDefault();
        alert('Please select a rating!');
        return;
      }
      
      if (comment === '') {
        e.preventDefault();
        alert('Please write a review!');
        return;
      }
      
      console.log('Rating:', selectedRating);
      console.log('Comment:', comment);
    });
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".detail-cards-wrapper");
  const prevBtn = document.querySelector(".detail-prev-btn");
  const nextBtn = document.querySelector(".detail-next-btn");

  if (!container || !prevBtn || !nextBtn) return;

  function getCardsPerScroll() {
    const width = window.innerWidth;
    if (width < 768) return 1;     // mobile
    return 3;                      // tablet + desktop
  }

  function getCardFullWidth() {
    const card = container.querySelector(".detail-stream-card");
    if (!card) return 0;

    const cardWidth = card.offsetWidth;
    const gap = parseInt(getComputedStyle(container).gap) || 0;

    return cardWidth + gap;
  }

  function updateButtons() {
    const maxScrollLeft =
      container.scrollWidth - container.clientWidth - 1;

    prevBtn.classList.toggle("is-disabled", container.scrollLeft <= 0);
    nextBtn.classList.toggle(
      "is-disabled",
      container.scrollLeft >= maxScrollLeft
    );
  }

  /* ===== Improve mobile scroll snap smoothness ===== */
let snapTimeout;

container.addEventListener("scroll", () => {
  if (window.innerWidth >= 768) return;

  clearTimeout(snapTimeout);

  snapTimeout = setTimeout(() => {
    const cardWidth = getCardFullWidth();
    if (!cardWidth) return;

    const index = Math.round(container.scrollLeft / cardWidth);

    container.scrollTo({
      left: index * cardWidth,
      behavior: "smooth",
    });
  }, 80); 
});


  function scrollSlider(direction) {
    const cardsPerScroll = getCardsPerScroll();
    const scrollAmount = getCardFullWidth() * cardsPerScroll;

    container.scrollBy({
      left: direction * scrollAmount,
      behavior: "smooth",
    });
  }

  prevBtn.addEventListener("click", () => scrollSlider(-1));
  nextBtn.addEventListener("click", () => scrollSlider(1));

  container.addEventListener("scroll", updateButtons);
  window.addEventListener("resize", updateButtons);

  // Init
  updateButtons();
});


