document.addEventListener('DOMContentLoaded', function() {
    // Khai báo biến
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const closeMenuBtn = document.getElementById('closeMenuBtn');
    const body = document.body;

    // Hàm mở menu
    function openMenu() {
        if(hamburgerBtn) hamburgerBtn.classList.add('active');
        if(mobileDrawer) mobileDrawer.classList.add('active');
        if(mobileOverlay) mobileOverlay.classList.add('active');
        body.style.overflow = 'hidden'; // Khóa cuộn trang
    }

    // Hàm đóng menu
    function closeMenu() {
        if(hamburgerBtn) hamburgerBtn.classList.remove('active');
        if(mobileDrawer) mobileDrawer.classList.remove('active');
        if(mobileOverlay) mobileOverlay.classList.remove('active');
        body.style.overflow = ''; // Mở lại cuộn trang
    }

    // Sự kiện Click vào Hamburger
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', function(e) {
            e.stopPropagation(); // Ngăn sự kiện nổi bọt
            if (mobileDrawer.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        });
    }

    // Sự kiện Click vào nút X
    if (closeMenuBtn) {
        closeMenuBtn.addEventListener('click', closeMenu);
    }

    // Sự kiện Click ra ngoài vùng đen (Overlay) thì đóng menu
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeMenu);
    }

    // Tự động đóng menu khi click vào link bên trong
    const mobileLinks = document.querySelectorAll('.mobile-nav a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            closeMenu();
        });
    });

    // Reset khi thay đổi kích thước màn hình (đang mở mobile mà kéo to ra PC thì đóng lại)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991 && mobileDrawer.classList.contains('active')) {
            closeMenu();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // ... (Code xử lý Hamburger cũ giữ nguyên ở đây) ...

    /* --- XỬ LÝ DROPDOWN MENU CHO MOBILE (MỚI) --- */
    
    // 1. Chọn tất cả các mục menu có con (WordPress tự sinh class 'menu-item-has-children')
    const menuParents = document.querySelectorAll('.mobile-nav .menu-item-has-children');

    menuParents.forEach(parent => {
        // 2. Tạo nút mũi tên
        const toggleBtn = document.createElement('span');
        toggleBtn.className = 'dropdown-toggle';
        // Dùng icon FontAwesome chevron-down
        toggleBtn.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';

        // 3. Chèn nút mũi tên vào sau thẻ <a> của mục cha
        const link = parent.querySelector('a');
        if (link) {
            link.after(toggleBtn);
        }

        // 4. Bắt sự kiện click vào nút mũi tên
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Chặn hành động mặc định
            
            // Toggle class active cho mũi tên (để xoay)
            this.classList.toggle('active');
            
            // Tìm menu con ngay kế tiếp
            const subMenu = parent.querySelector('.sub-menu');
            if (subMenu) {
                // Toggle class open cho menu con (để hiện/ẩn)
                subMenu.classList.toggle('open');
            }
        });
    });
});