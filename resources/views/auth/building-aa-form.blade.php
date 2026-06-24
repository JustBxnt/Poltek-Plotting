<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking Gedung AA</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body class="auth-page">
    <div class="page-shell">
        <div class="bg-blob bg-blob-1"></div>
        <div class="bg-blob bg-blob-2"></div>
        @if ($errors->any())
            <div class="form-alert form-alert-error">
                <p>Form belum bisa diproses. Periksa kembali isian Anda.</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="success-overlay" id="successOverlay">
                <div class="success-modal">
                    <h3>{{ session('success') }}</h3>
                    <p>Booking Anda sudah kami terima dan akan diproses oleh admin.</p>
                    <button type="button" class="btn-primary success-close" id="closeSuccess">Tutup</button>
                </div>
            </div>
        @endif

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
                <p class="eyebrow">Gedung AA</p>
                <h2>Form Booking Ruang Rapat Pimpinan </h2>
                <p>Anda memilih tanggal {{ $selectedDate->translatedFormat('d F Y') }}. Lengkapi form berikut untuk melanjutkan reservasi.</p>
                <div class="hero-actions">
                    <a href="{{ route('building.aa') }}" class="btn-primary">Kembali ke Kalender</a>
                </div>
            </div>

            <div class="card form-card">
                <div class="card-accent"></div>
                <form class="booking-form" method="POST" action="{{ route('bookings.store') }}">
                    @csrf
                    <input type="hidden" name="booking_date" value="{{ $selectedDate->toDateString() }}">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="booking_date">Tanggal Booking</label>
                            <input type="text" id="booking_date" value="{{ $selectedDate->translatedFormat('d F Y') }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="room">Ruangan</label>
                            <input type="text" id="room" value="Ruang Rapat Pimpinan" readonly>
                        </div>
                        <div class="form-group">
                            <label for="requester_name">Nama Pemohon</label>
                            <input type="text" id="requester_name" name="requester_name" placeholder="Masukkan nama" value="{{ old('requester_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="event">Acara</label>
                            <input type="text" id="event" name="event_name" placeholder="Masukkan nama acara" value="{{ old('event_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Waktu</label>
                            <input type="text" id="time" name="time_range" placeholder="Contoh: 09:00 - 11:00" value="{{ old('time_range') }}">
                        </div>
                        <div class="form-group">
                            <label for="users_count">Jumlah Pengguna</label>
                            <input type="number" id="users_count" name="users_count" min="1" placeholder="Masukkan jumlah pengguna" value="{{ old('users_count') }}">
                        </div>
                    </div>

                    <div class="hero-actions booking-actions">
                        <button type="submit" class="btn-primary">Ajukan Booking</button>
                        <a href="{{ route('building.aa') }}" class="btn-secondary">Batalkan</a>
                    </div>
                </form>
            </div>
        </section>
    </div>

    @if (session('success'))
        <script>
            const successOverlay = document.getElementById('successOverlay');
            const closeSuccess = document.getElementById('closeSuccess');

            closeSuccess?.addEventListener('click', () => {
                successOverlay?.remove();
            });

            successOverlay?.addEventListener('click', (event) => {
                if (event.target === successOverlay) {
                    successOverlay.remove();
                }
            });
        </script>
    @endif
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
