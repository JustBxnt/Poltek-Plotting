<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form {{ $facility->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="page-shell">
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
                    <p>Permohonan fasilitas umum sudah kami terima.</p>
                    <button type="button" class="btn-primary success-close" id="closeSuccess">Tutup</button>
                </div>
            </div>
        @endif

        <header class="topbar">
            <div class="brand">
                <img src="{{ asset('images/logo-universitas.png') }}" alt="Logo Universitas" class="brand-logo">
                <div class="brand-text">
                    <h1>Politeknik Negeri Malang</h1>
                    <p>{{ $facility->name }}</p>
                </div>
            </div>
            <nav class="topnav">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('dashboard.umum') }}">Dashboard Umum</a>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Fasilitas Umum</p>
                <h2>{{ $facility->name }}</h2>
                <p>Anda memilih tanggal {{ $selectedDate->translatedFormat('d F Y') }}. Lengkapi form berikut untuk melanjutkan permohonan.</p>
                <div class="hero-actions">
                    <a href="{{ route('facility.show', ['code' => $facility->code]) }}" class="btn-primary">Kembali ke Kalender</a>
                </div>
            </div>

            <div class="card form-card">
                <form class="booking-form" method="POST" action="{{ route('facility.bookings.store', ['code' => $facility->code]) }}">
                    @csrf
                    <input type="hidden" name="booking_date" value="{{ $selectedDate->toDateString() }}">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tanggal Booking</label>
                            <input type="text" value="{{ $selectedDate->translatedFormat('d F Y') }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Fasilitas</label>
                            <input type="text" value="{{ $facility->name }}" readonly>
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
                        <button type="submit" class="btn-primary">Ajukan Permohonan</button>
                        <a href="{{ route('facility.show', ['code' => $facility->code]) }}" class="btn-secondary">Batalkan</a>
                    </div>
                </form>
            </div>
        </section>
    </div>

    @if (session('success'))
        <script>
            window.alert(@json(session('success')));

            const successOverlay = document.getElementById('successOverlay');
            const closeSuccess = document.getElementById('closeSuccess');
            closeSuccess?.addEventListener('click', () => successOverlay?.remove());
            successOverlay?.addEventListener('click', (event) => {
                if (event.target === successOverlay) {
                    successOverlay.remove();
                }
            });
        </script>
    @endif
</body>
</html>