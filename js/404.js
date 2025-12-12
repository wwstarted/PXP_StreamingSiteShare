const searchForm = document.getElementById("google-search-form");
  const searchInput = document.getElementById("search-input");
  const searchBtn = document.getElementById("search-btn");

  function handleSearch() {
    const query = searchInput.value.trim();
    if (query) {
      const googleURL = `https://www.google.com/search?q=${encodeURIComponent(query)}`;
      window.open(googleURL, "_blank"); 
    }
  }

  searchForm.addEventListener("submit", function (e) {
    e.preventDefault();
    handleSearch();
  });

  // click search icon
  searchBtn.addEventListener("click", function () {
    handleSearch();
  });