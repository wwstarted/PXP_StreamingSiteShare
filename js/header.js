
        const hamburger = document.getElementById('hamburger');
        const mainNav = document.getElementById('mainNav');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const body = document.body;

        function toggleMenu() {
            hamburger.classList.toggle('active');
            mainNav.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            body.style.overflow = mainNav.classList.contains('active') ? 'hidden' : '';
        }

        hamburger.addEventListener('click', toggleMenu);
        mobileMenuOverlay.addEventListener('click', toggleMenu);

        // Close menu when clicking on a link
        const navLinks = mainNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    toggleMenu();
                }
            });
        });

        const navLinkss = mainNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', ()=>{
                if(window.innerWidth <= 768){
                    toggleMenu();
                }
            });
        });

        // Close menu on window resize if open
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && mainNav.classList.contains('active')) {
                toggleMenu();
            }
        });
