<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Gedung</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body class="auth-page">
    <div class="page-shell">
        <div class="bg-blob bg-blob-1"></div>
        <div class="bg-blob bg-blob-2"></div>
        <header class="topbar">
            <a href="/" class="brand">
                <img src="{{ asset('images/logo-universitas.png') }}" alt="Logo Universitas" class="brand-logo">
                <span>Politeknik Negeri Malang</span>
            </a>
            <nav class="nav">
                <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema">&#9789;</button>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="button" class="btn-secondary" onclick="confirmLogoutToHome(event)">Keluar</button>
                </form>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Akses Fasilitas</p>
                <h2>Pilih Gedung</h2>
                <p>Silakan pilih gedung atau fasilitas yang ingin Anda akses. Tampilan ini diselaraskan dengan halaman sebelumnya supaya terasa satu sistem yang utuh.</p>

                <div class="building-slideshow-container">
                    <div class="building-slideshow" id="buildingSlideshow" aria-label="Slideshow foto fasilitas kampus">
                        <div class="building-slide is-active">
                            <img src="{{ asset('images/' . rawurlencode('campus.jpg')) }}" alt="Tampilan area kampus Polinema">
                        </div>
                        <div class="building-slide">
                            <img src="{{ asset('images/' . rawurlencode('Audit AH depan 1.jpeg')) }}" alt="Gedung AH tampak depan 1">
                        </div>
                        <div class="building-slide">
                            <img src="{{ asset('images/' . rawurlencode('Audit AH depan 2.jpeg')) }}" alt="Gedung AH tampak depan 2">
                        </div>
                        <div class="building-slide">
                            <img src="{{ asset('images/' . rawurlencode('GRATER.jpeg')) }}" alt="Gedung GRATER Polinema">
                        </div>
                        
                        <!-- Navigation Arrows -->
                        <button type="button" class="slide-nav-btn prev" onclick="prevSlide(event)" aria-label="Slide sebelumnya">&#10094;</button>
                        <button type="button" class="slide-nav-btn next" onclick="nextSlide(event)" aria-label="Slide berikutnya">&#10095;</button>
                    </div>
                    <!-- Slide Indicators / Dots -->
                    <div class="slideshow-indicators" id="slideshowIndicators">
                        <span class="dot active" onclick="jumpToSlide(0)"></span>
                        <span class="dot" onclick="jumpToSlide(1)"></span>
                        <span class="dot" onclick="jumpToSlide(2)"></span>
                        <span class="dot" onclick="jumpToSlide(3)"></span>
                    </div>
                </div>
            </div>

            <div class="card building-card">
                <div class="card-accent"></div>
                <div class="building-list">
                    @forelse ($buildings as $building)
                        @php
                            $gradientClass = 'badge-default';
                            $code = strtoupper($building->code);
                            if ($code === 'AA') $gradientClass = 'badge-aa';
                            elseif ($code === 'AH') $gradientClass = 'badge-ah';
                            elseif ($code === 'AJ') $gradientClass = 'badge-aj';
                            elseif ($code === 'AK') $gradientClass = 'badge-ak';
                            elseif ($code === 'AM') $gradientClass = 'badge-am';
                        @endphp
                        <a class="building-item" href="{{ route('building.show', ['code' => $building->code]) }}">
                            <div class="building-item-header">
                                <div class="building-code-badge {{ $gradientClass }}">{{ $code }}</div>
                                <div class="building-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="building-item-body">
                                <h3 class="building-name">Gedung {{ $building->code }}</h3>
                                <p class="building-info">{{ $building->info }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="building-item no-buildings">
                            <p class="building-name">Belum ada gedung aktif</p>
                            <p class="building-info">Silakan minta admin mengaktifkan gedung dari halaman admin.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <!-- Logout Confirmation Modal -->
    <dialog id="logoutConfirmModal" class="login-modal">
        <div class="login-modal-header">
            <div>
                <div class="modal-eyebrow">Konfirmasi</div>
                <h2>Keluar ke Beranda?</h2>
            </div>
            <button class="modal-close" onclick="closeLogoutModal()">&times;</button>
        </div>
        <div class="login-modal-text">
            Apakah Anda yakin ingin keluar dari sesi aktif dan kembali ke Beranda?
        </div>
        <div class="login-modal-actions">
            <button class="modal-option modal-option-primary" onclick="proceedLogout()">Ya, Keluar</button>
            <button class="modal-option" onclick="closeLogoutModal()">Batal</button>
        </div>
    </dialog>

    <!-- Image Lightbox Modal -->
    <dialog id="imageLightboxModal" class="lightbox-modal">
        <div class="lightbox-content-container">
            <button type="button" class="lightbox-close" onclick="closeLightbox()">&times;</button>
            <img id="lightboxImage" src="" alt="Tampilan besar fasilitas kampus">
        </div>
    </dialog>

<script>
    function confirmLogoutToHome(event) {
        event.preventDefault();
        const logoutModal = document.getElementById('logoutConfirmModal');
        if (logoutModal) {
            logoutModal.showModal();
        }
    }

    function closeLogoutModal() {
        const logoutModal = document.getElementById('logoutConfirmModal');
        if (logoutModal) {
            logoutModal.close();
        }
    }

    function proceedLogout() {
        const form = document.getElementById('logoutForm');
        if (form) {
            form.submit();
        }
    }

    // Lightbox Modal Functions
    window.openLightbox = function(src, alt) {
        const modal = document.getElementById('imageLightboxModal');
        const img = document.getElementById('lightboxImage');
        if (modal && img) {
            img.src = src;
            img.alt = alt;
            modal.showModal();
        }
    };

    window.closeLightbox = function() {
        const modal = document.getElementById('imageLightboxModal');
        if (modal) {
            modal.close();
        }
    };

    // Close lightbox when clicking outside
    (function() {
        const lightbox = document.getElementById('imageLightboxModal');
        if (lightbox) {
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    lightbox.close();
                }
            });
        }
    })();

    // Slideshow control
    (function() {
        const slides = document.querySelectorAll('.building-slide');
        const dots = document.querySelectorAll('.slideshow-indicators .dot');
        let currentIndex = 0;
        let slideInterval;
        
        function showSlide(index) {
            if (slides.length === 0) return;
            slides[currentIndex].classList.remove('is-active');
            if (dots.length > currentIndex) dots[currentIndex].classList.remove('active');
            
            currentIndex = (index + slides.length) % slides.length;
            
            slides[currentIndex].classList.add('is-active');
            if (dots.length > currentIndex) dots[currentIndex].classList.add('active');
        }
        
        window.prevSlide = function(event) {
            if (event) event.stopPropagation();
            showSlide(currentIndex - 1);
            resetInterval();
        };
        
        window.nextSlide = function(event) {
            if (event) event.stopPropagation();
            showSlide(currentIndex + 1);
            resetInterval();
        };
        
        window.jumpToSlide = function(index) {
            showSlide(index);
            resetInterval();
        };
        
        function startInterval() {
            slideInterval = setInterval(() => {
                showSlide(currentIndex + 1);
            }, 5000);
        }
        
        function resetInterval() {
            clearInterval(slideInterval);
            startInterval();
        }
        
        // Touch Swipe & Click/Tap logic
        const container = document.getElementById('buildingSlideshow');
        if (container) {
            let startX = 0;
            let startY = 0;
            let endX = 0;
            let endY = 0;
            const dragThreshold = 8;
            
            container.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
            }, { passive: true });
            
            container.addEventListener('touchend', (e) => {
                if (e.target.closest('.slide-nav-btn')) return;
                endX = e.changedTouches[0].clientX;
                endY = e.changedTouches[0].clientY;
                
                const diffX = endX - startX;
                const diffY = endY - startY;
                
                if (Math.abs(diffX) < dragThreshold && Math.abs(diffY) < dragThreshold) {
                    // Tap/Click: Open lightbox
                    const activeImg = container.querySelector('.building-slide.is-active img');
                    if (activeImg) {
                        openLightbox(activeImg.src, activeImg.alt);
                    }
                } else {
                    handleSwipe(diffX);
                }
            }, { passive: true });
            
            // Mouse Drag/Swipe logic for desktop
            let isMouseDown = false;
            container.addEventListener('mousedown', (e) => {
                isMouseDown = true;
                startX = e.clientX;
                startY = e.clientY;
            });
            
            container.addEventListener('mouseup', (e) => {
                if (!isMouseDown) return;
                isMouseDown = false;
                if (e.target.closest('.slide-nav-btn')) return;
                endX = e.clientX;
                endY = e.clientY;
                
                const diffX = endX - startX;
                const diffY = endY - startY;
                
                if (Math.abs(diffX) < dragThreshold && Math.abs(diffY) < dragThreshold) {
                    // Click: Open lightbox
                    const activeImg = container.querySelector('.building-slide.is-active img');
                    if (activeImg) {
                        openLightbox(activeImg.src, activeImg.alt);
                    }
                } else {
                    handleSwipe(diffX);
                }
            });
            
            container.addEventListener('mouseleave', () => {
                isMouseDown = false;
            });
            
            function handleSwipe(diffX) {
                const threshold = 50;
                if (Math.abs(diffX) > threshold) {
                    if (diffX < 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                }
            }
        }
        
        startInterval();
    })();

    // Theme Toggle control
    (function() {
        const html = document.documentElement;
        const toggle = document.getElementById('themeToggle');
        const saved = localStorage.getItem('theme');
        if (saved === 'dark') {
            html.setAttribute('data-theme', 'dark');
            if (toggle) toggle.innerHTML = '&#9728;';
        }
        if (toggle) {
            toggle.addEventListener('click', function() {
                const isDark = html.getAttribute('data-theme') === 'dark';
                if (isDark) {
                    html.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'light');
                    toggle.innerHTML = '&#9789;';
                } else {
                    html.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                    toggle.innerHTML = '&#9728;';
                }
            });
        }
    })();
</script>
</body>
</html>
