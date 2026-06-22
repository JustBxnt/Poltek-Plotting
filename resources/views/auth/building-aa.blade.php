<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gedung AA</title>
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
                    <p>Ruang rapat pimpinan</p>
                </div>
            </div>
            <nav class="topnav">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('building.choose') }}">Pilih Gedung</a>
            </nav>
        </header>

        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Gedung AA</p>
                <h2>Ruang Rapat Pimpinan</h2>
                <p>Pilih tanggal pada bulan ini untuk melihat status ketersediaan ruangan. Warna abu-abu menandakan tersedia, sedangkan warna merah menandakan ruangan sudah digunakan.</p>
                <div class="hero-actions">
                    <a href="{{ route('building.choose') }}" class="btn-primary">Kembali ke Pilih Gedung</a>
                </div>
            </div>

            <div class="card calendar-card">
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
                            <p class="calendar-kicker">Kalender Ruangan</p>
                            <h3>{{ $today->translatedFormat('F Y') }}</h3>
                        </div>
                        <div class="calendar-legend">
                            <span><i class="legend-dot legend-available"></i>Tersedia</span>
                            <span><i class="legend-dot legend-used"></i>Digunakan</span>
                        </div>
                    </div>

                    <div class="calendar-weekdays">
                        <span>Min</span>
                        <span>Sen</span>
                        <span>Sel</span>
                        <span>Rab</span>
                        <span>Kam</span>
                        <span>Jum</span>
                        <span>Sab</span>
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
                                <div class="calendar-day is-used is-disabled" aria-disabled="true" title="Tanggal tidak tersedia">
                                    <span class="calendar-day-number">{{ $day }}</span>
                                    <span class="calendar-day-status">Digunakan</span>
                                </div>
                            @else
                                <a
                                    class="calendar-day is-available"
                                    href="{{ route('building.aa.form', ['day' => $day]) }}"
                                    title="Buka form booking untuk {{ $dateLabel }}"
                                >
                                    <span class="calendar-day-number">{{ $day }}</span>
                                    <span class="calendar-day-status">Tersedia</span>
                                </a>
                            @endif
                        @endfor
                    </div>

                    <div class="calendar-summary" id="calendarSummary">
                        <div class="detail-item">
                            <strong>Tanggal Terpilih</strong>
                            <span id="selectedDate">{{ $selectedDate->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <strong>Status Ruangan</strong>
                            <span id="selectedStatus">Tersedia</span>
                        </div>
                        <div class="detail-item">
                            <strong>Lokasi</strong>
                            <span>Gedung AA - Ruang rapat pimpinan</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>
</html>
