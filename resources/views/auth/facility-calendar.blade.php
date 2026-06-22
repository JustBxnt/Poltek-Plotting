<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $facility->name }}</title>
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
                    <p>Akses fasilitas umum</p>
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
                <p>{{ $facility->info }}</p>
                <div class="hero-actions">
                    <a href="{{ route('dashboard.umum') }}" class="btn-primary">Kembali ke Dashboard</a>
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
                                <div class="calendar-day is-used is-disabled" aria-disabled="true" title="Tanggal tidak tersedia">
                                    <span class="calendar-day-number">{{ $day }}</span>
                                    <span class="calendar-day-status">Digunakan</span>
                                </div>
                            @else
                                <a class="calendar-day is-available" href="{{ route('facility.form', ['code' => $facility->code, 'day' => $day]) }}" title="Buka form booking untuk {{ $dateLabel }}">
                                    <span class="calendar-day-number">{{ $day }}</span>
                                    <span class="calendar-day-status">Tersedia</span>
                                </a>
                            @endif
                        @endfor
                    </div>

                    <div class="calendar-summary">
                        <div class="detail-item">
                            <strong>Tanggal Terpilih</strong>
                            <span>{{ $selectedDate->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <strong>Status Fasilitas</strong>
                            <span>Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>