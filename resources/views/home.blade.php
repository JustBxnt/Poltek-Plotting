<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Universitas</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body class="home-page">
    <div class="page">
        <div class="topbar">
            <a href="/" class="brand">
                <img src="{{ asset('images/logo-universitas.png') }}" alt="Logo Universitas">
                <span>Politeknik Negeri Malang</span>
            </a>
            <nav class="nav">
                <a href="#" class="active">Beranda</a>
                <a href="{{ route('visi-misi') }}">Visi & Misi</a>
                <a href="#" class="login-btn" data-login-modal-open>Login</a>
                <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema">&#9789;</button>
            </nav>
        </div>

        <section class="hero">
            <div class="hero-card">
                <h1 class="hero-title">Selamat Datang di Sistem Informasi Kampus</h1>
                <p class="hero-text">Politeknik Negeri Malang menyediakan sarana dan prasarana yang dapat digunakan untuk berbagai acara kampus maupun umum. Hal ini meliputi ruang rapat yang terdapat pada gedung-gedung kampus serta fasilitas yang tersedia di tiap ruangan.</p>
                <div class="hero-slideshow" aria-label="Foto fasilitas kampus">
                    <div class="hero-slide is-active">
                        <img src="{{ asset('images/SELASAR GRAPOL.jpg') }}" alt="Selasar Graha Polinema">
                    </div>
                    <div class="hero-slide">
                        <img src="{{ asset('images/GRAPOL DALAM.jpeg') }}" alt="Interior Graha Polinema">
                    </div>
                    <div class="hero-slide">
                        <img src="{{ asset('images/GRATER.jpeg') }}" alt="Graha Polinema area depan">
                    </div>
                    <div class="hero-slide">
                        <img src="{{ asset('images/MASJID DALAM.jpeg') }}" alt="Bagian dalam masjid kampus">
                    </div>
                    <div class="hero-slide">
                        <img src="{{ asset('images/MASJID TAMPAK ATAS.jpeg') }}" alt="Masjid kampus tampak atas">
                    </div>
                </div>
            </div>
            <div class="info-panel">
                <div class="panel">
                    <h3>Informasi Kampus</h3>
                    <p>Politeknik Negeri Malang menyediakan sarana dan prasarana yang dapat digunakan untuk berbagai acara kampus maupun umum. Hal ini meliputi ruang rapat yang terdapat pada gedung-gedung kampus serta fasilitas yang tersedia di tiap ruangan.</p>
                </div>
            </div>
        </section>

        <dialog class="login-modal" id="loginModal" aria-labelledby="loginModalTitle">
            <div class="login-modal-header">
                <div>
                    <p class="modal-eyebrow">Pilih Akses</p>
                    <h2 id="loginModalTitle">Login</h2>
                </div>
                <button type="button" class="modal-close" data-login-modal-close aria-label="Tutup popup">&times;</button>
            </div>
            <p class="login-modal-text">Silakan pilih jenis login yang sesuai dengan akun Anda.</p>
            <div class="login-modal-actions">
                <a href="{{ route('login.mahasiswa') }}" class="modal-option modal-option-primary">Mahasiswa</a>
                <a href="{{ route('login.dosen') }}" class="modal-option">Dosen</a>
                <a href="{{ route('login.umum') }}" class="modal-option">Umum</a>
            </div>
        </dialog>
    </div>

    <script>
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

        const loginModal = document.getElementById('loginModal');
        const openButtons = document.querySelectorAll('[data-login-modal-open]');
        const closeButton = document.querySelector('[data-login-modal-close]');
        const slides = document.querySelectorAll('.hero-slide');
        let activeSlideIndex = 0;

        if (slides.length > 1) {
            setInterval(() => {
                slides[activeSlideIndex].classList.remove('is-active');
                activeSlideIndex = (activeSlideIndex + 1) % slides.length;
                slides[activeSlideIndex].classList.add('is-active');
            }, 3500);
        }

        openButtons.forEach((button) => {
            button.addEventListener('click', () => {
                if (typeof loginModal.showModal === 'function') {
                    loginModal.showModal();
                }
            });
        });

        closeButton?.addEventListener('click', () => loginModal.close());

        loginModal?.addEventListener('click', (event) => {
            const dialogRect = loginModal.getBoundingClientRect();
            const clickedOutside = (
                event.clientX < dialogRect.left ||
                event.clientX > dialogRect.right ||
                event.clientY < dialogRect.top ||
                event.clientY > dialogRect.bottom
            );

            if (clickedOutside) {
                loginModal.close();
            }
        });
    </script>
</body>
</html>
