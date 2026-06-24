<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body class="profile-page">
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary">Keluar</button>
                </form>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <div class="hero-badge">Akun Terverifikasi</div>
                <p class="eyebrow">Selamat Datang, {{ Auth::user()->name }}!</p>
                <h2>Profil Mahasiswa</h2>
                <p>Halaman ini menampilkan identitas akun aktif dan pintasan utama untuk melanjutkan akses ke fasilitas kampus.</p>
                <div class="hero-actions">
                    <a href="{{ route('building.choose') }}" class="btn-primary">Pilih Gedung</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="visual-card">
                    <div class="visual-card-accent"></div>
                    <img src="{{ asset('images/campus.jpg') }}" alt="Ilustrasi Kampus" class="campus-illustration">
                </div>
            </div>
        </section>

        <section class="info-grid">
            <div class="card">
                <div class="card-accent"></div>
                <div class="card-icon">&#128100;</div>
                <h3>Informasi Akun</h3>
                <p>Identitas yang sedang aktif pada sesi login ini.</p>
                <ul class="detail-list">
                    <li class="detail-item"><strong>Nama</strong><span>{{ Auth::user()->name }}</span></li>
                    <li class="detail-item"><strong>Email</strong><span>{{ Auth::user()->email }}</span></li>
                    <li class="detail-item"><strong>Peran</strong><span class="role-badge">{{ ucfirst(Auth::user()->role ?? session('role')) }}</span></li>
                </ul>
            </div>
            <div class="card">
                <div class="card-accent"></div>
                <div class="card-icon">&#9881;</div>
                <h3>Menu Cepat</h3>
                <p>Pintasan untuk masuk ke halaman yang paling sering dipakai.</p>
                <ul class="detail-list">
                    <li class="detail-item"><strong>Pilih Gedung</strong><span><a href="{{ route('building.choose') }}" class="detail-link">Masuk &#8599;</a></span></li>
                    <li class="detail-item"><strong>Beranda</strong><span><a href="{{ url('/') }}" class="detail-link">Kembali &#8599;</a></span></li>
                </ul>
            </div>
            <div class="card">
                <div class="card-accent"></div>
                <div class="card-icon">&#127979;</div>
                <h3>Info Kampus</h3>
                <p>Gedung kampus ditampilkan sesuai akses mahasiswa dan dosen. Jika Anda memerlukan fasilitas umum, gunakan halaman umum yang tersedia.</p>
            </div>
        </section>
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
</script>
</body>
</html>
