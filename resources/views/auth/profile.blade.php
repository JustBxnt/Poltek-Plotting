<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <div class="brand">
                <img src="{{ asset('images/logo-universitas.png') }}" alt="Logo Universitas" class="brand-logo">
                <div class="brand-text">
                    <h1>Politeknik Negeri Malang</h1>
                    <p>Ringkasan akun dan akses mahasiswa</p>
                </div>
            </div>
            <nav class="topnav">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('building.choose') }}">Pilih Gedung</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary">Keluar</button>
                </form>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Selamat Datang</p>
                <h2>Profil Mahasiswa</h2>
                <p>Halaman ini menampilkan identitas akun aktif dan pintasan utama untuk melanjutkan akses ke fasilitas kampus.</p>
                <div class="hero-actions">
                    <a href="{{ route('building.choose') }}" class="btn-primary">Pilih Gedung</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="visual-card">
                    <img src="{{ asset('images/campus.jpg') }}" alt="Ilustrasi Kampus" class="campus-illustration">
                </div>
            </div>
        </section>

        <section class="info-grid">
            <div class="card">
                <h3>Informasi Akun</h3>
                <p>Identitas yang sedang aktif pada sesi login ini.</p>
                <ul class="detail-list">
                    <li class="detail-item"><strong>Nama</strong><span>{{ Auth::user()->name }}</span></li>
                    <li class="detail-item"><strong>Email</strong><span>{{ Auth::user()->email }}</span></li>
                    <li class="detail-item"><strong>Peran</strong><span>{{ ucfirst(Auth::user()->role ?? session('role')) }}</span></li>
                </ul>
            </div>
            <div class="card">
                <h3>Menu Cepat</h3>
                <p>Pintasan untuk masuk ke halaman yang paling sering dipakai.</p>
                <ul class="detail-list">
                    <li class="detail-item"><strong>Pilih Gedung</strong><span><a href="{{ route('building.choose') }}">Buka</a></span></li>
                    <li class="detail-item"><strong>Beranda</strong><span><a href="{{ url('/') }}">Kembali</a></span></li>
                </ul>
            </div>
            <div class="card">
                <h3>Info Kampus</h3>
                <p>Gedung kampus ditampilkan sesuai akses mahasiswa dan dosen. Jika Anda memerlukan fasilitas umum, gunakan halaman umum yang tersedia.</p>
            </div>
        </section>
    </div>
</body>
</html>
