document.addEventListener('DOMContentLoaded', function () {
    const openMenuBtn = document.getElementById("openMenuBtn");
    const closeMenuBtn = document.getElementById("closeMenuBtn");
    const mobileDrawer = document.getElementById("mobileDrawer");
    const mobileOverlay = document.getElementById("mobileOverlay");
    const body = document.body;

    function openMenu() {
        mobileDrawer.classList.add("active");
        mobileOverlay.classList.add("active");
        body.style.overflow = "hidden"; 
    }

    function closeMenu() {
        mobileDrawer.classList.remove("active");
        mobileOverlay.classList.remove("active");
        body.style.overflow = ""; 
    }

    if (openMenuBtn) {
        openMenuBtn.addEventListener("click", openMenu);
    }

    if (closeMenuBtn) {
        closeMenuBtn.addEventListener("click", closeMenu);
    }

    if (mobileOverlay) {
        mobileOverlay.addEventListener("click", closeMenu);
    }

    // Click link → đóng menu
    document.querySelectorAll(".mobile-nav a").forEach(link => {
        link.addEventListener("click", closeMenu);
    });

    // Khi phóng to lên desktop → reset menu
    window.addEventListener("resize", function () {
        if (window.innerWidth > 991) {
            closeMenu();
        }
    });

    const menuParents = document.querySelectorAll('.mobile-nav .menu-item-has-children');

    menuParents.forEach(parent => {
        const link = parent.querySelector("a");
        const subMenu = parent.querySelector(".sub-menu");

        if (!link || !subMenu) return;

        // Tạo nút toggle
        const toggleBtn = document.createElement("span");
        toggleBtn.className = "dropdown-toggle";
        toggleBtn.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';

        link.after(toggleBtn);

        toggleBtn.addEventListener("click", function (e) {
            e.preventDefault();

            // Toggle mũi tên
            this.classList.toggle("active");

            // Toggle submenu
            subMenu.classList.toggle("open");
        });
    });

});
