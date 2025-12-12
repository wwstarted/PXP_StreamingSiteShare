class StreamingSearch {
  constructor() {
    // WordPress REST API Endpoints
    this.API_POST_ITEMS = window.location.origin + '/PXP_SSW/wordpress/wp-json/wp/v2/posts';
    this.API_BLOGS = window.location.origin + '/PXP_SSW/wordpress/wp-json/wp/v2/blogs';
    
    this.state = {
      query: '',
      postItemResults: [],
      blogResults: [],
      allPostItems: [],
      allBlogs: [],
      isLoading: false,
      isOpen: false,
      selectedIndex: -1,
      error: null,
      cache: {}
    };
    
    this.debounceTimer = null;
    this.MIN_CHARS = 3;
    this.MAX_RESULTS_PER_SECTION = 5;
    this.DEBOUNCE_TIME = 400;
    
    this.init();
  }

  async init() {
    this.cacheElements();
    if (!this.searchInput) {
      console.error('Search input not found');
      return;
    }
    this.attachEvents();
    await this.fetchAllData();
  }

  cacheElements() {
    this.searchContainer = document.querySelector('.input-search-icon');
    this.searchInput = this.searchContainer?.querySelector('input[type="text"]');
    this.searchIcon = this.searchContainer?.querySelector('.icon-search');
    
    if (this.searchContainer && this.searchInput) {
      this.createDropdown();
    }
  }

  createDropdown() {
    const dropdown = document.createElement('div');
    dropdown.className = 'search-dropdown';
    dropdown.innerHTML = `
      <div class="search-dropdown-content">
        <div class="search-loading">
          <i class="fa-solid fa-spinner fa-spin"></i>
          <span>Searching...</span>
        </div>
        <div class="search-results">
          <!-- Streaming Sites Section -->
          <div class="search-section" id="streaming-section">
            <div class="search-section-header">
              <i class="fa-solid fa-tv"></i>
              <span>STREAMING SITES</span>
            </div>
            <div class="search-section-results" id="streaming-results"></div>
          </div>
          
          <!-- Blog Section -->
          <div class="search-section" id="blog-section">
            <div class="search-section-header">
              <i class="fa-solid fa-newspaper"></i>
              <span>ARTICLES</span>
            </div>
            <div class="search-section-results" id="blog-results"></div>
          </div>
        </div>
        <div class="search-empty">
          <i class="fa-solid fa-magnifying-glass"></i>
          <p>No results found</p>
          <span>Try different keywords</span>
        </div>
        <div class="search-error">
          <i class="fa-solid fa-triangle-exclamation"></i>
          <p>Something went wrong</p>
          <span>Please try again later</span>
        </div>
      </div>
    `;
    
    this.searchContainer.style.position = 'relative';
    this.searchContainer.appendChild(dropdown);
    this.dropdown = dropdown;
    this.streamingContainer = dropdown.querySelector('#streaming-results');
    this.blogContainer = dropdown.querySelector('#blog-results');
    this.streamingSection = dropdown.querySelector('#streaming-section');
    this.blogSection = dropdown.querySelector('#blog-section');
  }

  async fetchAllData() {
    try {
      const [postItemsRes, blogsRes] = await Promise.all([
        fetch(this.API_POST_ITEMS + '?per_page=100'),
        fetch(this.API_BLOGS + '?per_page=100')
      ]);
      
      if (!postItemsRes.ok || !blogsRes.ok) {
        throw new Error('Failed to fetch data');
      }
      
      this.state.allPostItems = await postItemsRes.json();
      this.state.allBlogs = await blogsRes.json();
      
      console.log('✅ Loaded streaming sites:', this.state.allPostItems.length);
      console.log('✅ Loaded blogs:', this.state.allBlogs.length);
    } catch (error) {
      console.error('❌ Error fetching data:', error);
      this.state.error = error.message;
    }
  }

  attachEvents() {
    this.searchInput.addEventListener('input', (e) => this.handleInput(e));
    this.searchInput.addEventListener('focus', () => this.handleFocus());
    this.searchInput.addEventListener('keydown', (e) => this.handleKeyboard(e));
    document.addEventListener('click', (e) => this.handleClickOutside(e));
  }

  handleInput(e) {
    const query = e.target.value.trim();
    this.state.query = query;
    clearTimeout(this.debounceTimer);
    this.state.selectedIndex = -1;

    if (query.length < this.MIN_CHARS) {
      this.closeDropdown();
      return;
    }

    this.showLoading();
    this.debounceTimer = setTimeout(() => {
      this.performSearch(query);
    }, this.DEBOUNCE_TIME);
  }

  handleFocus() {
    if (this.state.query.length >= this.MIN_CHARS) {
      const hasResults = this.state.postItemResults.length > 0 || this.state.blogResults.length > 0;
      if (hasResults) this.openDropdown();
    }
  }

  handleKeyboard(e) {
    if (!this.state.isOpen) return;

    const totalResults = this.state.postItemResults.length + this.state.blogResults.length;
    if (totalResults === 0) return;

    switch(e.key) {
      case 'ArrowDown':
        e.preventDefault();
        this.navigateDown(totalResults);
        break;
      case 'ArrowUp':
        e.preventDefault();
        this.navigateUp(totalResults);
        break;
      case 'Enter':
        e.preventDefault();
        if (this.state.selectedIndex >= 0) {
          this.selectCurrentItem();
        }
        break;
      case 'Escape':
        this.closeDropdown();
        this.searchInput.blur();
        break;
    }
  }

  navigateDown(total) {
    if (this.state.selectedIndex < total - 1) {
      this.state.selectedIndex++;
      this.updateSelectedItem();
    }
  }

  navigateUp(total) {
    if (this.state.selectedIndex > 0) {
      this.state.selectedIndex--;
      this.updateSelectedItem();
    }
  }

  updateSelectedItem() {
    const allItems = this.dropdown.querySelectorAll('.search-result-item');
    allItems.forEach((item, index) => {
      if (index === this.state.selectedIndex) {
        item.classList.add('selected');
        item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
      } else {
        item.classList.remove('selected');
      }
    });
  }

  selectCurrentItem() {
    const allItems = this.dropdown.querySelectorAll('.search-result-item');
    const selectedItem = allItems[this.state.selectedIndex];
    if (selectedItem) {
      const link = selectedItem.dataset.link;
      window.location.href = link;
    }
  }

  handleClickOutside(e) {
    if (!this.searchContainer.contains(e.target)) {
      this.closeDropdown();
    }
  }

  performSearch(query) {
    const cacheKey = query.toLowerCase();
    
    if (this.state.cache[cacheKey]) {
      console.log('📦 Using cached results');
      const cached = this.state.cache[cacheKey];
      this.state.postItemResults = cached.postItems;
      this.state.blogResults = cached.blogs;
      this.renderResults();
      return;
    }

    const queryLower = query.toLowerCase();
    
    const filteredPostItems = this.state.allPostItems.filter(item => {
      const title = item.title?.rendered?.toLowerCase() || '';
      const desc = item.meta?.desc?.toLowerCase() || '';
      return title.includes(queryLower) || desc.includes(queryLower);
    }).slice(0, this.MAX_RESULTS_PER_SECTION);

    const filteredBlogs = this.state.allBlogs.filter(blog => {
      const title = blog.title?.rendered?.toLowerCase() || '';
      const desc = blog.meta?.bg_short_desc?.toLowerCase() || '';
      return title.includes(queryLower) || desc.includes(queryLower);
    }).slice(0, this.MAX_RESULTS_PER_SECTION);

    this.state.postItemResults = filteredPostItems;
    this.state.blogResults = filteredBlogs;

    this.state.cache[cacheKey] = {
      postItems: filteredPostItems,
      blogs: filteredBlogs
    };

    this.renderResults();
  }


  renderResults() {
    this.state.isLoading = false;
    const hasPostItems = this.state.postItemResults.length > 0;
    const hasBlogs = this.state.blogResults.length > 0;

    if (!hasPostItems && !hasBlogs) {
      this.showEmpty();
      return;
    }

    this.openDropdown();
    this.hideLoading();
    this.hideEmpty();
    this.hideError();

    if (hasPostItems) {
      this.streamingSection.style.display = 'block';
      this.renderStreamingSites();
    } else {
      this.streamingSection.style.display = 'none';
    }

    if (hasBlogs) {
      this.blogSection.style.display = 'block';
      this.renderBlogs();
    } else {
      this.blogSection.style.display = 'none';
    }
  }

  renderStreamingSites() {
    const html = this.state.postItemResults.map((item, index) => {
      const title = item.title?.rendered || 'Untitled';
      const desc = item.desc || 'Esta canción quería dedicársela a alguien pero al final no lo merece así q mejor no, ya llegará alguien a mi vida q si merezca que le dedique esta hermosa canción';
      const link = item.link || '#';
      const logo = item.logo || '';
      const popularity = item.popularity || 0;
      const highlightedTitle = this.highlightText(title, this.state.query);

      return `
        <div class="search-result-item" data-index="${index}" data-link="${link}">
          <div class="search-result-image">
            ${logo ? `<img src="${logo}" alt="${title}" onerror="this.parentElement.innerHTML='<div class=\\'search-result-placeholder\\'><i class=\\'fa-solid fa-tv\\'></i></div>'">` : `<div class="search-result-placeholder"><i class="fa-solid fa-tv"></i></div>`}
          </div>
          <div class="search-result-content">
            <div class="search-result-header">
              <h4 class="search-result-title">${highlightedTitle}</h4>
              ${popularity > 0 ? `<div class="search-result-rating"><i class="fa-solid fa-star"></i> ${popularity}%</div>` : ''}
            </div>
            <p class="search-result-excerpt">${this.truncate(this.stripHtml(desc), 100)}</p>
          </div>
          <div class="search-result-arrow">
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </div>
      `;
    }).join('');

    this.streamingContainer.innerHTML = html;
    this.attachClickEvents(this.streamingContainer);
  }

  renderBlogs() {
    const html = this.state.blogResults.map((blog, index) => {
      const title = blog.title?.rendered || 'Untitled';
      const desc = blog.meta?.bg_short_desc || '';
      const link = blog.link || '#';
      const thumbnail = blog.meta?.bg_thumbnail || '';
      const author = blog.meta?.bg_author || '';
      const date = blog.meta?.bg_date || '';
      const highlightedTitle = this.highlightText(title, this.state.query);

      return `
        <div class="search-result-item" data-index="${this.state.postItemResults.length + index}" data-link="${link}">
          <div class="search-result-image">
            ${thumbnail ? `<img src="${thumbnail}" alt="${title}" onerror="this.parentElement.innerHTML='<div class=\\'search-result-placeholder\\'><i class=\\'fa-solid fa-newspaper\\'></i></div>'">` : `<div class="search-result-placeholder"><i class="fa-solid fa-newspaper"></i></div>`}
          </div>
          <div class="search-result-content">
            <h4 class="search-result-title">${highlightedTitle}</h4>
            <p class="search-result-excerpt">${this.truncate(this.stripHtml(desc), 100)}</p>
            ${author || date ? `<div class="search-result-meta">
              ${author ? `<i class="fa-solid fa-user"></i> ${author}` : ''}
              ${author && date ? ' • ' : ''}
              ${date ? date : ''}
            </div>` : ''}
          </div>
          <div class="search-result-arrow">
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </div>
      `;
    }).join('');

    this.blogContainer.innerHTML = html;
    this.attachClickEvents(this.blogContainer);
  }

  attachClickEvents(container) {
    container.querySelectorAll('.search-result-item').forEach(item => {
      item.addEventListener('click', () => {
        window.location.href = item.dataset.link;
      });
    });
  }

  highlightText(text, query) {
    if (!query) return text;
    const regex = new RegExp(`(${this.escapeRegex(query)})`, 'gi');
    return text.replace(regex, '<mark>$1</mark>');
  }

  escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  stripHtml(html) {
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '';
  }

  truncate(text, length) {
    return text.length > length ? text.substring(0, length) + '...' : text;
  }

  showLoading() {
    this.state.isLoading = true;
    this.openDropdown();
    this.dropdown.classList.add('loading');
    this.dropdown.classList.remove('empty', 'error');
  }

  hideLoading() {
    this.dropdown.classList.remove('loading');
  }

  showEmpty() {
    this.openDropdown();
    this.dropdown.classList.add('empty');
    this.dropdown.classList.remove('loading', 'error');
  }

  hideEmpty() {
    this.dropdown.classList.remove('empty');
  }

  showError() {
    this.openDropdown();
    this.dropdown.classList.add('error');
    this.dropdown.classList.remove('loading', 'empty');
  }

  hideError() {
    this.dropdown.classList.remove('error');
  }

  openDropdown() {
    this.state.isOpen = true;
    this.dropdown.classList.add('active');
  }

  closeDropdown() {
    this.state.isOpen = false;
    this.state.selectedIndex = -1;
    this.dropdown.classList.remove('active');
  }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  new StreamingSearch();
});