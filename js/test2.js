document.addEventListener('DOMContentLoaded', function() {
    const particlesContainer = document.getElementById('particles');
    
    if (particlesContainer) {
        for (let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.width = Math.random() * 100 + 50 + 'px';
            particle.style.height = particle.style.width;
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particlesContainer.appendChild(particle);
        }
    }

    const searchForm = document.getElementById('google-search-form');
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');

    function handleSearch(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        
        if (query) {
            const googleURL = `https://www.google.com/search?q=${encodeURIComponent(query)}`;
            window.open(googleURL, '_blank');
            searchInput.value = '';
        }
    }

    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', handleSearch);
    }

    async function renderCategories() {
        const container = document.getElementById('categories-container');
        
        if (!container) return;

        try {
            const wpHome = window.location.origin + window.location.pathname.split('/wp-content')[0];
            const API_BASE = wpHome + '/wp-json/wp/v2';

            // Fetch categories and posts in parallel
            const [categoriesRes, postsRes] = await Promise.all([
                fetch(`https://streamingsite.proxyflowpxp.com/wp-json/wp/v2/categories?per_page=100`),
                fetch(`https://streamingsite.proxyflowpxp.com/wp-json/wp/v2/posts?per_page=100`)
            ]);

            const allCategories = await categoriesRes.json();
            const allPosts = await postsRes.json();

            const visibleCategories = allCategories.filter(cate => {
                const visible = cate.meta?._cate_visible;
                return visible === '1' || visible === 1 || visible === true;
            });

            const categoriesToShow = visibleCategories.slice(0, 4);

            container.innerHTML = '';

            if (categoriesToShow.length === 0) {
                container.innerHTML = '<div class="loading-categories">No categories available</div>';
                return;
            }

            categoriesToShow.forEach((cate, index) => {
                const thumbnail = cate.meta?.thumbnail || '';
                const name = cate.name || 'Untitled';
                const link = cate.link || '#';
                const firstLetter = name.charAt(0).toUpperCase();

                const postsCount = allPosts.filter(post => {
                    const cats = post.categories || [];
                    return cats.includes(cate.id);
                }).length;

                const postsText = postsCount === 1 ? '1 site available' : `${postsCount} sites available`;

                const categoryCard = document.createElement('a');
                categoryCard.className = 'category-card-horizontal';
                categoryCard.href = link;
                categoryCard.style.opacity = '0';
                categoryCard.style.transform = 'translateY(20px)';

                categoryCard.innerHTML = `
                    <div class="category-thumbnail-circle">
                        ${thumbnail
                            ? `<img src="${thumbnail}" alt="${name}" />`
                            : `<div class="category-thumbnail-fallback">${firstLetter}</div>`
                        }
                    </div>
                    <div class="category-info">
                        <div class="category-name-horizontal">${name}</div>
                        <div class="category-posts-count">${postsText}</div>
                    </div>
                    <div class="category-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                `;

                container.appendChild(categoryCard);

                // Stagger animation
                setTimeout(() => {
                    categoryCard.style.transition = 'all 0.5s ease';
                    categoryCard.style.opacity = '1';
                    categoryCard.style.transform = 'translateY(0)';
                }, 100 * (index + 1));
            });

        } catch (error) {
            console.error('Error fetching categories:', error);
            container.innerHTML = '<div class="loading-categories">Failed to load categories</div>';
        }
    }

    renderCategories();

});