<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Gedung</title>
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
                    <p>Portal resmi kampus untuk akses mahasiswa</p>
                </div>
            </div>
            <nav class="topnav">
                <a href="{{ url('/') }}">Beranda</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary">Keluar</button>
                </form>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Akses Fasilitas</p>
                <h2>Pilih Gedung</h2>
                <p>Silakan pilih gedung atau fasilitas yang ingin Anda akses. Tampilan ini diselaraskan dengan halaman sebelumnya supaya terasa satu sistem yang utuh.</p>

                <div class="building-slideshow" aria-label="Slideshow foto fasilitas kampus">
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
                </div>
            </div>

            <div class="card building-card">
                <div class="building-list">
                    @forelse ($buildings as $building)
                        <a class="building-item" href="{{ route('building.show', ['code' => $building->code]) }}">
                            <p class="building-name">Gedung {{ $building->code }}</p>
                            <p class="building-info">{{ $building->info }}</p>
                        </a>
                    @empty
                        <div class="building-item">
                            <p class="building-name">Belum ada gedung aktif</p>
                            <p class="building-info">Silakan minta admin mengaktifkan gedung dari halaman admin.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</body>
</html>