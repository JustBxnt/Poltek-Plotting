<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $facility->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body class="auth-page">
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
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="button" class="btn-secondary" onclick="confirmLogoutToHome(event)">Keluar</button>
                </form>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Fasilitas Umum</p>
                <h2>{{ $facility->name }}</h2>
                <p>{{ $facility->info }}</p>
                <div class="hero-actions">
                    <a href="{{ route('dashboard.umum') }}" class="btn-primary">Kembali ke Dashboard</a>
                </div>
            </div>

            <div class="card calendar-card">
                <div class="card-accent"></div>
                @php
                    $today = $today ?? \Carbon\Carbon::today();
                    $monthStart = $monthStart ?? $today->copy()->startOfMonth();
                    $daysInMonth = $daysInMonth ?? $today->daysInMonth;
                    $usedDays = $usedDays ?? [];
                    $selectedDay = $selectedDay ?? 1;
                    $selectedDate = $selectedDate ?? $today->copy()->day($selectedDay);
                @endphp

                <div class="calendar-panel">
                    <div class="calendar-header">
                        <div>
                            <p class="calendar-kicker">Kalender Fasilitas</p>
                            <h3>{{ $today->translatedFormat('F Y') }}</h3>
                        </div>
                        <div class="calendar-legend">
                            <span><i class="legend-dot legend-available"></i>Tersedia</span>
                            <span><i class="legend-dot legend-used"></i>Digunakan</span>
                        </div>
                    </div>

                    <div class="calendar-weekdays">
                        <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
                    </div>

                    <div class="calendar-grid">
                        @for ($i = 0; $i < $monthStart->dayOfWeek; $i++)
                            <span class="calendar-empty"></span>
                        @endfor

                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $isUsed = in_array($day, $usedDays, true);
                                $dateLabel = $today->copy()->day($day)->translatedFormat('d F Y');
                            @endphp
                            @if ($isUsed)
                                <div 
                                    class="calendar-day is-used {{ $day === 1 ? 'is-selected' : '' }}"
                                    data-day="{{ $day }}"
                                    data-date="{{ $dateLabel }}"
                                    data-status="Digunakan"
                                    title="Tanggal tidak tersedia"
                                >
                                    <span class="calendar-day-number">{{ $day }}</span>
                                    <span class="calendar-day-status">Digunakan</span>
                                </div>
                            @else
                                <a 
                                    class="calendar-day is-available {{ $day === 1 ? 'is-selected' : '' }}" 
                                    href="{{ route('facility.form', ['code' => $facility->code, 'day' => $day]) }}" 
                                    data-day="{{ $day }}"
                                    data-date="{{ $dateLabel }}"
                                    data-status="Tersedia"
                                    data-url="{{ route('facility.form', ['code' => $facility->code, 'day' => $day]) }}"
                                    title="Buka form booking untuk {{ $dateLabel }}"
                                >
                                    <span class="calendar-day-number">{{ $day }}</span>
                                    <span class="calendar-day-status">Tersedia</span>
                                </a>
                            @endif
                        @endfor
                    </div>

                    @php
                        $firstDayIsUsed = in_array(1, $usedDays, true);
                    @endphp
                    <div class="calendar-summary" id="calendarSummary">
                        <div class="detail-item">
                            <strong>Tanggal Terpilih</strong>
                            <span id="selectedDate">{{ $selectedDate->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <strong>Status Fasilitas</strong>
                            <span id="selectedStatus">{{ $firstDayIsUsed ? 'Digunakan' : 'Tersedia' }}</span>
                        </div>
                        <div class="calendar-action" style="margin-top: 20px; display: grid;">
                            <a 
                                id="bookingActionButton" 
                                class="btn-primary {{ $firstDayIsUsed ? 'is-disabled' : '' }}" 
                                @if(!$firstDayIsUsed) href="{{ route('facility.form', ['code' => $facility->code, 'day' => 1]) }}" @endif
                                style="width: 100%; justify-content: center; text-align: center; align-items: center; display: inline-flex; {{ $firstDayIsUsed ? 'pointer-events: none;' : '' }}"
                            >
                                Lanjutkan Booking
                            </a>
                        </div>
                    </div>
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

    // Calendar Selection Logic
    document.addEventListener('DOMContentLoaded', function() {
        const days = document.querySelectorAll('.calendar-day');
        const selectedDateSpan = document.getElementById('selectedDate');
        const selectedStatusSpan = document.getElementById('selectedStatus');
        const bookingBtn = document.getElementById('bookingActionButton');

        // Style the initial status color
        if (selectedStatusSpan) {
            const initialStatus = selectedStatusSpan.textContent.trim();
            if (initialStatus === 'Digunakan') {
                selectedStatusSpan.style.color = '#ef4444';
            } else {
                selectedStatusSpan.style.color = '#22c55e';
            }
        }

        days.forEach(day => {
            day.addEventListener('click', function(e) {
                if (day.tagName === 'A') {
                    e.preventDefault();
                }

                // Update selected class
                days.forEach(d => d.classList.remove('is-selected'));
                day.classList.add('is-selected');

                // Get day details from data attributes
                const dateLabel = day.getAttribute('data-date');
                const status = day.getAttribute('data-status');
                const bookingUrl = day.getAttribute('data-url');

                // Update summary text
                if (selectedDateSpan) selectedDateSpan.textContent = dateLabel;
                if (selectedStatusSpan) {
                    selectedStatusSpan.textContent = status;
                    if (status === 'Digunakan') {
                        selectedStatusSpan.style.color = '#ef4444';
                    } else {
                        selectedStatusSpan.style.color = '#22c55e';
                    }
                }

                // Update booking button
                if (bookingBtn) {
                    if (status === 'Tersedia' && bookingUrl) {
                        bookingBtn.href = bookingUrl;
                        bookingBtn.classList.remove('is-disabled');
                        bookingBtn.style.pointerEvents = 'auto';
                    } else {
                        bookingBtn.removeAttribute('href');
                        bookingBtn.classList.add('is-disabled');
                        bookingBtn.style.pointerEvents = 'none';
                    }
                }
            });
        });
    });

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
