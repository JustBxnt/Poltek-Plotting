<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="page-shell admin-shell">
        <header class="topbar">
            <div class="brand">
                <img src="{{ asset('images/logo-universitas.png') }}" alt="Logo Universitas" class="brand-logo">
                <div class="brand-text">
                    <h1>Politeknik Negeri Malang</h1>
                    <p>Dashboard admin</p>
                </div>
            </div>
            <nav class="topnav">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary">Keluar</button>
                </form>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Administrasi</p>
                <h2>Dashboard Admin</h2>
                <p>Semua pengajuan booking masuk ke sini. Admin bisa mengubah status gedung, lalu meng-ACC atau menolak form booking dari satu tempat.</p>
                @if (session('status'))
                    <div class="admin-alert">{{ session('status') }}</div>
                @endif
            </div>

            <div class="card building-card">
                <div class="detail-list">
                    <div class="detail-item">
                        <strong>Total Gedung</strong>
                        <span>{{ $buildings->count() }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Booking Masuk</strong>
                        <span>{{ $bookings->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Booking Disetujui</strong>
                        <span>{{ $bookings->where('status', 'approved')->count() }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="info-grid admin-grid">
            <div class="card admin-section-card">
                <h3>Status Gedung</h3>
                <div class="building-list">
                    @foreach ($buildings as $building)
                        <div class="admin-building-row">
                            <div>
                                <p class="building-name">Gedung {{ $building->code }}</p>
                                <p class="building-info">{{ $building->info }}</p>
                            </div>
                            <div class="admin-actions">
                                <span class="status-badge {{ $building->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $building->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                                <form method="POST" action="{{ route('admin.buildings.toggle', $building) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-secondary">
                                        {{ $building->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card admin-section-card admin-bookings-card">
                <h3>Form Booking Masuk</h3>
                <p class="building-info" style="margin-bottom: 16px;">Pilih kategori pemohon untuk melihat dan mengelola booking:</p>

                @php
                    $roleLinks = [
                        'mahasiswa' => ['label' => 'Pemohon Mahasiswa', 'route' => 'admin.pemohon.mahasiswa'],
                        'dosen' => ['label' => 'Pemohon Dosen', 'route' => 'admin.pemohon.dosen'],
                        'umum' => ['label' => 'Pemohon Umum', 'route' => 'admin.pemohon.umum'],
                        'lainnya' => ['label' => 'Pemohon Lainnya', 'route' => 'admin.pemohon.lainnya'],
                    ];
                @endphp

                <div class="booking-list">
                    @foreach ($roleLinks as $key => $link)
                        @php
                            $total = $key === 'lainnya'
                                ? $bookings->filter(fn ($b) => !in_array($b->requester_role, ['mahasiswa', 'dosen', 'umum'], true))
                                : $bookings->where('requester_role', $key);
                            $pending = $total->where('status', 'pending')->count();
                        @endphp
                        <a href="{{ route($link['route']) }}" class="building-item" style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p class="building-name">{{ $link['label'] }}</p>
                                <p class="building-info">{{ $total->count() }} booking</p>
                            </div>
                            @if ($pending > 0)
                                <span class="status-badge status-pending">{{ $pending }} menunggu</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</body>
</html>
