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
                <a href="#" class="login-btn" data-login-modal-open>Login</a>
                <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema">&#9789;</button>
            </nav>
        </div>

        <section class="hero">
            <div class="hero-content">
                <div class="hero-badge">✨ Sistem Plotting & Booking Sarpras</div>
                <h1 class="hero-title">Sistem Peminjaman <span class="gradient-text">Gedung & Ruangan</span></h1>
                <p class="hero-text">Politeknik Negeri Malang menyediakan sarana dan prasarana terbaik yang siap digunakan untuk menunjang berbagai kegiatan akademik, kemahasiswaan, maupun acara umum. Cek ketersediaan ruang secara real-time dan ajukan peminjaman dengan mudah.</p>
                
                <div class="hero-actions">
                    <button class="btn-cta primary" data-login-modal-open>Mulai Booking Sekarang</button>
                    <button type="button" class="btn-cta secondary" data-visi-modal-open>Lihat Visi & Misi</button>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">12+</span>
                        <span class="stat-label">Gedung Utama</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Ruang Rapat & Aula</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Proses Online</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-visual-home">
                <div class="slideshow-container">
                    <div class="hero-slideshow" aria-label="Foto fasilitas kampus">
                        <div class="hero-slide is-active">
                            <img src="{{ asset('images/SELASAR GRAPOL.jpg') }}" alt="Selasar Graha Polinema">
                            <div class="slide-caption">Selasar Graha Polinema</div>
                        </div>
                        <div class="hero-slide">
                            <img src="{{ asset('images/GRAPOL DALAM.jpeg') }}" alt="Interior Graha Polinema">
                            <div class="slide-caption">Interior Graha Polinema</div>
                        </div>
                        <div class="hero-slide">
                            <img src="{{ asset('images/GRATER.jpeg') }}" alt="Graha Polinema area depan">
                            <div class="slide-caption">Graha Polinema Area Depan</div>
                        </div>
                        <div class="hero-slide">
                            <img src="{{ asset('images/MASJID DALAM.jpeg') }}" alt="Bagian dalam masjid kampus">
                            <div class="slide-caption">Interior Masjid Al-Taqwa</div>
                        </div>
                        <div class="hero-slide">
                            <img src="{{ asset('images/MASJID TAMPAK ATAS.jpeg') }}" alt="Masjid kampus tampak atas">
                            <div class="slide-caption">Masjid Kampus Polinema</div>
                        </div>
                    </div>
                    <div class="slideshow-glow"></div>
                </div>
            </div>
        </section>

        <section class="features-section">
            <div class="feature-card">
                <div class="feature-icon">🏫</div>
                <h3>Peminjaman Ruangan</h3>
                <p>Akses ke berbagai aula, ruang rapat, dan gedung serbaguna untuk keperluan acara akademik maupun non-akademik.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Jadwal Real-Time</h3>
                <p>Sistem plotting yang terintegrasi memungkinkan Anda melihat ketersediaan ruangan secara langsung dan instan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Proses Digital</h3>
                <p>Pengajuan surat izin dan verifikasi status peminjaman secara transparan dari pihak administrasi kampus.</p>
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
                <a href="{{ route('login.mahasiswa') }}" class="modal-option">Mahasiswa</a>
                <a href="{{ route('login.dosen') }}" class="modal-option">Dosen</a>
                <a href="{{ route('login.umum') }}" class="modal-option">Umum</a>
            </div>
        </dialog>

        <!-- Visi & Misi Modal -->
        <dialog class="login-modal visi-modal" id="visiModal" aria-labelledby="visiModalTitle">
            <div class="login-modal-header">
                <div>
                    <p class="modal-eyebrow">Politeknik Negeri Malang</p>
                    <h2 id="visiModalTitle">Visi & Misi</h2>
                </div>
                <button type="button" class="modal-close" data-visi-modal-close aria-label="Tutup popup">&times;</button>
            </div>
            <div class="visi-modal-content" style="margin-top: 20px; text-align: left; max-height: 60vh; overflow-y: auto; padding-right: 8px;">
                <h3 style="font-size: 1.15rem; color: var(--accent); margin-bottom: 8px; font-weight: 700;">Visi</h3>
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text); margin-bottom: 20px;">
                    Menjadi Lembaga Pendidikan Tinggi Vokasi yang Unggul dalam Persaingan Global.
                </p>
                
                <h3 style="font-size: 1.15rem; color: var(--accent); margin-bottom: 8px; font-weight: 700;">Misi</h3>
                <ol style="font-size: 0.95rem; line-height: 1.6; color: var(--text); padding-left: 20px; display: grid; gap: 10px; margin: 0 0 20px 0;">
                    <li>Menyelenggarakan dan Mengembangkan Pendidikan Vokasi yang Berkualitas, Inovatif, dan Berdaya Saing yang Mendorong Pola Pembelajaran Seumur Hidup dan Tumbuhnya Jiwa Kewirausahaan serta Sesuai Kebutuhan Industri, Lembaga Pemerintah, dan Masyarakat.</li>
                    <li>Menyelenggarakan Penelitian Terapan yang Bermanfaat bagi Pengembangan Ilmu Pengetahuan dan Teknologi serta Kesejahteraan Masyarakat.</li>
                    <li>Menyelenggarakan Pengabdian Kepada Masyarakat yang Bermanfaat bagi Kesejahteraan Masyarakat.</li>
                    <li>Menyelenggarakan Sistem Pengelolaan Pendidikan dengan Berdasar pada Prinsip-prinsip Tatapamong yang Baik.</li>
                    <li>Mengembangkan Kerjasama yang Saling Menguntungkan dengan Berbagai Pihak, baik di Dalam maupun di Luar Negeri pada Bidang-bidang yang Relevan.</li>
                </ol>

                <h3 style="font-size: 1.15rem; color: var(--accent); margin-bottom: 8px; font-weight: 700;">Tentang</h3>
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--muted); margin: 0;">
                    Politeknik Negeri Malang berkomitmen untuk menjadi lembaga pendidikan vokasi terdepan dalam persaingan global melalui pendidikan berkualitas, penelitian terapan, dan pengabdian kepada masyarakat.
                </p>
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

        // Visi & Misi Modal Script
        const visiModal = document.getElementById('visiModal');
        const openVisiButtons = document.querySelectorAll('[data-visi-modal-open]');
        const closeVisiButton = document.querySelector('[data-visi-modal-close]');

        openVisiButtons.forEach((button) => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                if (typeof visiModal.showModal === 'function') {
                    visiModal.showModal();
                }
            });
        });

        closeVisiButton?.addEventListener('click', () => visiModal.close());

        visiModal?.addEventListener('click', (event) => {
            const dialogRect = visiModal.getBoundingClientRect();
            const clickedOutside = (
                event.clientX < dialogRect.left ||
                event.clientX > dialogRect.right ||
                event.clientY < dialogRect.top ||
                event.clientY > dialogRect.bottom
            );

            if (clickedOutside) {
                visiModal.close();
            }
        });
    </script>
</body>
</html>
