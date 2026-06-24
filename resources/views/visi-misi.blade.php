<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi & Misi - Politeknik Negeri Malang</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body class="home-page visi-misi-page">
    <div class="page">
        <div class="topbar">
            <a href="/" class="brand">
                <img src="{{ asset('images/logo-universitas.png') }}" alt="Logo Universitas">
                <span>Politeknik Negeri Malang</span>
            </a>
            <nav class="nav">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('visi-misi') }}" class="active">Visi & Misi</a>
                <a href="#" class="login-btn" data-login-modal-open>Login</a>
                <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema">&#9789;</button>
            </nav>
        </div>

        <section class="hero">
            <div class="hero-card">
                <h1 class="hero-title">Visi Dan Misi</h1>

                <p class="hero-text" style="margin-bottom: 2px;"><strong>Visi:</strong></p>
                <p class="hero-text" style="margin-top: 0;">Menjadi Lembaga Pendidikan Tinggi Vokasi yang Unggul dalam Persaingan Global</p>

                <p class="hero-text" style="margin-bottom: 2px;"><strong>Misi:</strong></p>
                <ol style="line-height: 1.6; padding-left: 20px; display: grid; gap: 12px; margin: 0;">
                    <li>Menyelenggarakan dan Mengembangkan Pendidikan Vokasi yang Berkualitas, Inovatif, dan Berdaya Saing yang Mendorong Pola Pembelajaran Seumur Hidup dan Tumbuhnya Jiwa Kewirausahaan serta Sesuai Kebutuhan Industri, Lembaga Pemerintah, dan Masyarakat.</li>
                    <li>Menyelenggarakan Penelitian Terapan yang Bermanfaat bagi Pengembangan Ilmu Pengetahuan dan Teknologi serta Kesejahteraan Masyarakat.</li>
                    <li>Menyelenggarakan Pengabdian Kepada Masyarakat yang Bermanfaat bagi Kesejahteraan Masyarakat.</li>
                    <li>Menyelenggarakan Sistem Pengelolaan Pendidikan dengan Berdasar pada Prinsip-prinsip Tatapamong yang Baik.</li>
                    <li>Mengembangkan Kerjasama yang Saling Menguntungkan dengan Berbaga Pihak, baik di Dalam maupun di Luar Negeri pada Bidang-bidang yang Relevan.</li>
                </ol>
            </div>
            <div class="info-panel">
                <div class="panel">
                    <h3>Tentang</h3>
                    <p>Politeknik Negeri Malang berkomitmen untuk menjadi lembaga pendidikan vokasi terdepan dalam persaingan global melalui pendidikan berkualitas, penelitian terapan, dan pengabdian kepada masyarakat.</p>
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