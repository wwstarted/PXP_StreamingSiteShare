document.addEventListener("DOMContentLoaded", async () => {
  const API_BASE = "http://localhost/PXP_SSW/wordpress/wp-json/wp/v2";
  const WP_HOME = window.WP_HOME || "";
  
  let allBlogs = [];
  let allCategories = [];
  let currentCategory = "all";
  let currentSort = "newest";
  let displayedBlogs = 6;
  const blogsPerLoad = 6;
  
  function calculateReadTime(content) {
    const wordsPerMinute = 200;
    const wordCount = content.split(/\s+/).length;
    const minutes = Math.ceil(wordCount / wordsPerMinute);
    return minutes;
  }

  function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", { 
      year: 'numeric', 
      month: 'short', 
      day: 'numeric' 
    });
  }

  function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + "...";
  }

// hero slider ======
  
  async function renderHeroSlider() {
    const heroSection = document.querySelector(".hero-slider-section");
    if (!heroSection) return;

    try {
      const res = await fetch(`${API_BASE}/blogs?per_page=5`);
      const blogs = await res.json();

      const visibleBlogs = blogs.filter(blog => {
        const isVisible = blog.meta?._blogs_visible;
        return isVisible === "1" || isVisible === true || isVisible === 1;
      });

      if (!visibleBlogs.length) return;

      const slidesHTML = visibleBlogs.map((blog, index) => {
        const meta = blog.meta || {};
        const title = blog.title?.rendered || "No Title";
        const desc = meta.bg_short_desc || "No description available.";
        const image = meta.bg_thumbnail || "https://via.placeholder.com/1200x600";
        
        // ✅ SỬA: Dùng author mặc định của WP
        const authorName = blog.author_name || "Unknown Author";
        const authorAvatar = blog.author_avatar || "";
        
        const date = formatDate(blog.date);
        const readTime = calculateReadTime(desc);

        return `
          <div class="hero-slide ${index === 0 ? 'active' : ''}">
            <img src="${image}" alt="${title}" class="hero-slide-image" />
            <div class="hero-slide-overlay"></div>
            <div class="hero-slide-content">
              <span class="hero-slide-badge">Featured</span>
              <h1 class="hero-slide-title">${title}</h1>
              <p class="hero-slide-excerpt">${truncateText(desc, 200)}</p>
              <div class="hero-slide-meta">
                <div class="hero-author">
                  <img src="${authorAvatar}" alt="${authorName}" class="hero-author-avatar" />
                  <span class="hero-author-name">${authorName}</span>
                </div>
                <span class="hero-date">
                  <i class="fa-regular fa-calendar"></i> ${date}
                </span>
                <span class="hero-read-time">
                  <i class="fa-regular fa-clock"></i> ${readTime} min read
                </span>
              </div>
              <a href="${blog.link || '#'}" class="hero-slide-btn">
                Read Article <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>
        `;
      }).join('');

      const dotsHTML = visibleBlogs.map((_, index) => 
        `<div class="hero-dot ${index === 0 ? 'active' : ''}" data-slide="${index}"></div>`
      ).join('');

      heroSection.innerHTML = `
        <div class="hero-slides-wrapper">
          ${slidesHTML}
        </div>
        <div class="hero-nav-arrows">
          <div class="hero-arrow hero-prev">
            <i class="fa-solid fa-chevron-left"></i>
          </div>
          <div class="hero-arrow hero-next">
            <i class="fa-solid fa-chevron-right"></i>
          </div>
        </div>
        <div class="hero-dots">${dotsHTML}</div>
      `;

      initSlider(visibleBlogs.length);
    } catch (err) {
      console.error("Error loading hero slider:", err);
    }
  }

  function initSlider(totalSlides) {
    let currentSlide = 0;
    let autoPlayInterval;

    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    const prevBtn = document.querySelector('.hero-prev');
    const nextBtn = document.querySelector('.hero-next');

    function goToSlide(index) {
      slides.forEach(slide => slide.classList.remove('active'));
      dots.forEach(dot => dot.classList.remove('active'));
      
      currentSlide = (index + totalSlides) % totalSlides;
      
      slides[currentSlide].classList.add('active');
      dots[currentSlide].classList.add('active');
    }

    function nextSlide() {
      goToSlide(currentSlide + 1);
    }

    function prevSlide() {
      goToSlide(currentSlide - 1);
    }

    function startAutoPlay() {
      autoPlayInterval = setInterval(nextSlide, 5000);
    }

    function stopAutoPlay() {
      clearInterval(autoPlayInterval);
    }

    // Event listeners
    nextBtn?.addEventListener('click', () => {
      nextSlide();
      stopAutoPlay();
      startAutoPlay();
    });

    prevBtn?.addEventListener('click', () => {
      prevSlide();
      stopAutoPlay();
      startAutoPlay();
    });

    dots.forEach(dot => {
      dot.addEventListener('click', () => {
        const slideIndex = parseInt(dot.dataset.slide);
        goToSlide(slideIndex);
        stopAutoPlay();
        startAutoPlay();
      });
    });

    startAutoPlay();
  }

// main content blogs grid ===================
  
  async function fetchAllData() {
    try {
      // Fetch categories
      const cateRes = await fetch(`${API_BASE}/blog_category`);
      allCategories = await cateRes.json();

      // Fetch all blogs
      const blogRes = await fetch(`${API_BASE}/blogs?per_page=100`);
      allBlogs = await blogRes.json();

      // Filter visible blogs
      allBlogs = allBlogs.filter(blog => {
        const isVisible = blog.meta?._blogs_visible;
        return isVisible === "1" || isVisible === true || isVisible === 1;
      });

      renderCategoryTabs();
      renderBlogGrid();
    } catch (err) {
      console.error("Error fetching data:", err);
    }
  }

  function renderCategoryTabs() {
    const tabsWrapper = document.querySelector('.blog-tabs');
    if (!tabsWrapper) return;

    const allTabHTML = `<div class="blog-tab active" data-category="all">All Posts</div>`;
    
    const categoryTabsHTML = allCategories.map(category => 
      `<div class="blog-tab" data-category="${category.id}">${category.name}</div>`
    ).join('');

    tabsWrapper.innerHTML = allTabHTML + categoryTabsHTML;

    // Add click events
    document.querySelectorAll('.blog-tab').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.blog-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        currentCategory = tab.dataset.category;
        displayedBlogs = blogsPerLoad;
        renderBlogGrid();
      });
    });
  }

  function getFilteredAndSortedBlogs() {
    let filtered = [...allBlogs];

    // Filter by category
    if (currentCategory !== 'all') {
      filtered = filtered.filter(blog => {
        const categories = blog.blog_category || [];
        return categories.includes(parseInt(currentCategory));
      });
    }

    // Filter by search
    const searchInput = document.querySelector('.blog-search-input');
    if (searchInput && searchInput.value.trim()) {
      const searchTerm = searchInput.value.toLowerCase();
      filtered = filtered.filter(blog => {
        const title = blog.title?.rendered?.toLowerCase() || '';
        const desc = blog.meta?.bg_short_desc?.toLowerCase() || '';
        return title.includes(searchTerm) || desc.includes(searchTerm);
      });
    }

    // Sort
    if (currentSort === 'newest') {
      filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
    } else if (currentSort === 'oldest') {
      filtered.sort((a, b) => new Date(a.date) - new Date(b.date));
    } else if (currentSort === 'popular') {
      filtered.sort(() => Math.random() - 0.5);
    }

    return filtered;
  }

  function renderBlogGrid() {
    const gridContainer = document.querySelector('.blog-grid-modern');
    if (!gridContainer) return;

    const filteredBlogs = getFilteredAndSortedBlogs();
    const blogsToShow = filteredBlogs.slice(0, displayedBlogs);

    if (!blogsToShow.length) {
      gridContainer.innerHTML = `
        <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px; color: rgba(255,255,255,0.5);">
          <i class="fa-solid fa-inbox" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
          <p style="font-size: 18px;">No blog posts found</p>
        </div>
      `;
      updateLoadMoreButton(false);
      return;
    }

    const cardsHTML = blogsToShow.map(blog => {
      const meta = blog.meta || {};
      const title = blog.title?.rendered || "No Title";
      const desc = meta.bg_short_desc || "No description available.";
      const image = meta.bg_avatar || "https://via.placeholder.com/400x300";
      
      // ✅ SỬA: Dùng author mặc định của WP
      const authorName = blog.author_name || "Unknown Author";
      const authorAvatar = blog.author_avatar || "";
      
      const date = formatDate(blog.date);
      const readTime = calculateReadTime(desc);
      
      // Get category name
      const categoryId = blog.blog_category?.[0];
      const category = allCategories.find(c => c.id === categoryId);
      const categoryName = category?.name || "Uncategorized";

      return `
        <article class="blog-card-modern">
          <div class="blog-card-image-wrapper">
            <img src="${image}" alt="${title}" class="blog-card-image-modern" />
            <div class="blog-card-image-overlay"></div>
            <span class="blog-card-category-badge">${categoryName}</span>
          </div>
          <div class="blog-card-content-modern">
            <h3 class="blog-card-title-modern">${title}</h3>
            <p class="blog-card-excerpt-modern">${truncateText(desc, 120)}</p>
            <div class="blog-card-meta-modern">
              <div class="blog-card-author-modern">
                <img src="${authorAvatar}" alt="${authorName}" class="blog-card-avatar-modern" />
                <div class="blog-card-author-info">
                  <span class="blog-card-author-name">${authorName}</span>
                  <span class="blog-card-date-modern">${date}</span>
                </div>
              </div>
              <div class="blog-card-stats">
                <span class="blog-card-stat">
                  <i class="fa-regular fa-clock"></i> ${readTime}m
                </span>
                <a href="${blog.link || '#'}" class="blog-card-stat" style="color: var(--accent-purple); text-decoration: none;">
                  <i class="fa-solid fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </article>
      `;
    }).join('');

    gridContainer.innerHTML = cardsHTML;

    // Update load more button
    updateLoadMoreButton(blogsToShow.length < filteredBlogs.length);
  }

  function updateLoadMoreButton(show) {
    const loadMoreSection = document.querySelector('.blog-load-more');
    if (!loadMoreSection) return;

    if (show) {
      loadMoreSection.style.display = 'block';
    } else {
      loadMoreSection.style.display = 'none';
    }
  }


  // search & sort
  
  function initSearchAndSort() {
    const searchInput = document.querySelector('.blog-search-input');
    const sortSelect = document.querySelector('.blog-sort-select');

    if (searchInput) {
      let searchTimeout;
      searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          displayedBlogs = blogsPerLoad;
          renderBlogGrid();
        }, 500);
      });
    }

    if (sortSelect) {
      sortSelect.addEventListener('change', (e) => {
        currentSort = e.target.value;
        displayedBlogs = blogsPerLoad;
        renderBlogGrid();
      });
    }
  }

// ============== render load more ======================
  
  function initLoadMore() {
    const loadMoreBtn = document.querySelector('.load-more-btn');
    if (!loadMoreBtn) return;

    loadMoreBtn.addEventListener('click', () => {
      displayedBlogs += blogsPerLoad;
      renderBlogGrid();
      
      setTimeout(() => {
        const cards = document.querySelectorAll('.blog-card-modern');
        const targetCard = cards[displayedBlogs - blogsPerLoad];
        if (targetCard) {
          targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
      }, 100);
    });
  }

  await renderHeroSlider();
  await fetchAllData();
  initSearchAndSort();
  initLoadMore();
});