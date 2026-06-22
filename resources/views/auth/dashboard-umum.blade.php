<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Umum</title>
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
                    <p>Portal resmi kampus untuk akses umum</p>
                </div>
            </div>
            <nav class="topnav">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="#fasilitas-umum">Fasilitas Umum</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary">Keluar</button>
                </form>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Selamat Datang</p>
                <h2>Dashboard Umum</h2>
                <p>Silakan pilih fasilitas kampus yang tersedia untuk umum. Daftar di halaman ini sudah disesuaikan khusus untuk pengguna umum.</p>
                <div class="hero-actions">
                    <a href="#fasilitas-umum" class="btn-primary">Lihat Fasilitas</a>
                </div>
            </div>

            <div class="card building-card" id="fasilitas-umum">
                <div class="building-list facility-grid">
                    @foreach ($publicFacilities as $facility)
                        <a class="building-item" href="{{ route('facility.show', ['code' => $facility->code]) }}">
                            <p class="building-name">{{ $facility->name }}</p>
                            <p class="building-info">{{ $facility->info }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</body>
</html>