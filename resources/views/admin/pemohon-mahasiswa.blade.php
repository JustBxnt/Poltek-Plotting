<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemohon Mahasiswa - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="page-shell admin-shell">
        <header class="topbar">
            <a href="/" class="brand">
                <img src="{{ asset('images/logo-universitas.png') }}" alt="Logo Universitas" class="brand-logo">
                <span>Politeknik Negeri Malang</span>
            </a>
            <nav class="nav">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.buildings.index') }}">Status Gedung</a>
                <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ganti tema">&#9789;</button>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="button" class="btn-secondary" onclick="confirmLogoutToHome(event)">Keluar</button>
                </form>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Admin</p>
                <h2>Pemohon Mahasiswa</h2>
                <p>Daftar booking dari mahasiswa.</p>
                @if (session('status'))
                    <div class="admin-alert">{{ session('status') }}</div>
                @endif
            </div>
        </section>

        <section class="admin-full-width">
            <div class="card admin-section-card admin-bookings-card">
                <h3>Form Booking Masuk</h3>
                <div class="booking-list">
                    @forelse ($bookings as $booking)
                        <div class="booking-row">
                            <div>
                                <p class="building-name">{{ $booking->building->name ?? 'Gedung' }}</p>
                                <p class="building-info">
                                    {{ $booking->booking_date->translatedFormat('d F Y') }} - {{ $booking->event_name }}
                                </p>
                                <p class="building-info">
                                    <span class="time-badge">Jam {{ $booking->time_range ?? '-' }}</span>
                                </p>
                                <p class="building-info">
                                    Pemohon: {{ $booking->requester_name }} | Pengguna: {{ $booking->users_count ?? '-' }}
                                </p>
                            </div>
                            <div class="admin-actions">
                                <span class="status-badge {{ $booking->status === 'approved' ? 'status-active' : ($booking->status === 'rejected' ? 'status-inactive' : 'status-pending') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                @if ($booking->status === 'pending')
                                    <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-primary">ACC</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-secondary">Tolak</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="return confirm('Hapus booking ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="building-info">Belum ada booking dari mahasiswa.</p>
                    @endforelse
                </div>
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

    window.confirmLogoutToHome = function(event) {
        event.preventDefault();
        const logoutModal = document.getElementById('logoutConfirmModal');
        if (logoutModal) {
            logoutModal.showModal();
        }
    };

    window.closeLogoutModal = function() {
        const logoutModal = document.getElementById('logoutConfirmModal');
        if (logoutModal) {
            logoutModal.close();
        }
    };

    window.proceedLogout = function() {
        const form = document.getElementById('logoutForm');
        if (form) {
            form.submit();
        }
    };
</script>

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
</body>
</html>