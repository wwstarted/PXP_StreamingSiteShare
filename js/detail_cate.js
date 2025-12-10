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

  // ---------- Get slug & post id ----------
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

  // ---------- Reading Progress Bar ----------
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

  // ---------- UI events ----------
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

  // ---------- Main ----------
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

  // ---------- SECTION 3: Left Content - PREMIUM STYLE ----------
  try {
    const contentleft = document.querySelector("#content-left");
    if (contentleft) {
      const postTitle = currentPost?.title?.rendered || "No title";
      const postDesc = currentPost?.meta?._post_item_content || "No description available.";
      const likesRaw = currentPost?.meta?.likes || "[]";
      const hatesRaw = currentPost?.meta?.hates || "[]";
      const likes = parseMaybeJson(likesRaw) || [];
      const hates = parseMaybeJson(hatesRaw) || [];

      // Build likes HTML
      const likeHTML = Array.isArray(likes) && likes.length > 0
        ? likes.map(item => `<li>${item}</li>`).join("")
        : "<li>No likes listed.</li>";

      // Build hates HTML
      const hateHTML = Array.isArray(hates) && hates.length > 0
        ? hates.map(item => `<li>${item}</li>`).join("")
        : "<li>No dislikes listed.</li>";

      // Premium layout with inner wrapper
      contentleft.innerHTML = `
        <div class="left-content-inner">
          <h3>${postTitle}</h3>
          <p>${postDesc}</p>
          
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

      // Initialize reading progress after content is rendered
      setTimeout(initReadingProgress, 100);
    }
  } catch (err) {
    console.error("Lỗi khi render left content:", err);
  }

  // ---------- SECTION 4: Good & Bad (Right Sidebar) ----------
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

// ---------- SECTION 5: Comment Box Enhancement ----------
try {
  const commentBox = document.querySelector(".comment-box");
  if (commentBox) {
    // Replace entire comment box with new structure
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

    // Initialize star rating functionality
    setTimeout(() => {
      const starsContainer = document.getElementById('starsInput');
      const starBtns = starsContainer?.querySelectorAll('.star-btn');
      let selectedRating = 0;

      if (starBtns) {
        starBtns.forEach(btn => {
          // Click handler
          btn.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            
            // Update visual state
            starBtns.forEach((star, index) => {
              if (index < selectedRating) {
                star.classList.add('active');
              } else {
                star.classList.remove('active');
              }
            });
          });

          // Hover effect
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

      // Submit validation
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
          
          // If validation passes, link will work normally
          console.log('Rating:', selectedRating);
          console.log('Comment:', comment);
        });
      }
    }, 100);
  }
} catch (err) {
  console.error("Lỗi when render comment box:", err);
}

  // ---------- SECTION 5: Related Posts ----------
try {
  const detailsContainer = document.querySelector("#details-container");
  if (!detailsContainer) {
    console.warn("Không tìm thấy #details-container");
  } else {
    // Get current post's category IDs
    const currentCateIds = toNumberArray(currentPost?.meta?.id_cate_post);
    
    if (!currentCateIds.length) {
      detailsContainer.innerHTML = `
        <p style="text-align: center; color: rgba(255,255,255,0.5); padding: 40px 20px;">
          No related streaming sites found.
        </p>
      `;
    } else {
      // Fetch all posts
      const perPage = 100;
      const allRes = await fetch(`${API_BASE}/post_item?per_page=${perPage}`);
      const allPosts = await allRes.json();

      // Filter related posts (same category, exclude current post)
      const relatedPosts = (Array.isArray(allPosts) ? allPosts : [])
        .filter(p => {
          const pCateIds = toNumberArray(p?.meta?.id_cate_post);
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
          const meta = post?.meta || {};
          
          // Get data
          const image = meta.image || meta.bgr_image || "https://via.placeholder.com/400x200";
          const logo = meta.logo || "";
          const title = post?.title?.rendered || "No Title";
          const link = post?.link || "#";
          const popularity = meta.popularity || "";
          
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



document.addEventListener('DOMContentLoaded', function() {
  const starsContainer = document.getElementById('starsInput');
  const starBtns = starsContainer?.querySelectorAll('.star-btn');
  let selectedRating = 0;

  if (starBtns) {
    starBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        selectedRating = parseInt(this.dataset.rating);
        
        // Update visual state
        starBtns.forEach((star, index) => {
          if (index < selectedRating) {
            star.classList.add('active');
          } else {
            star.classList.remove('active');
          }
        });
      });

      // Hover effect
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

  // Optional: Handle submit button click
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
      
      // If validation passes, link will work normally
      console.log('Rating:', selectedRating);
      console.log('Comment:', comment);
    });
  }
});

const detailContainer = document.querySelector(".detail-cards-wrapper");
const detailNextBtn = document.querySelector(".detail-next-btn");
const detailPrevBtn = document.querySelector(".detail-prev-btn");

if (detailNextBtn && detailPrevBtn && detailContainer) {
  detailNextBtn.addEventListener("click", () => {
    detailContainer.scrollBy({ left: 340, behavior: "smooth" });
  });
  detailPrevBtn.addEventListener("click", () => {
    detailContainer.scrollBy({ left: -340, behavior: "smooth" });
  });
}