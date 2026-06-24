<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Booking;
use App\Models\Building;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

$ensureBookingSchema = function (): void {
    if (! Schema::hasColumn('buildings', 'kind')) {
        Schema::table('buildings', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->string('kind')->default('building')->after('info');
        });

        Building::query()->update(['kind' => 'building']);
    }

    if (! Schema::hasColumn('bookings', 'requester_role')) {
        Schema::table('bookings', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->string('requester_role')->nullable()->after('requester_name');
        });
    }
};

$getActiveBookingDays = function (): array {
    $today = Carbon::today();

    return Booking::query()
        ->whereHas('building', fn ($query) => $query->where('code', 'AA'))
        ->where('status', 'approved')
        ->whereDate('booking_date', '>=', $today->copy()->startOfMonth()->toDateString())
        ->whereDate('booking_date', '<=', $today->copy()->endOfMonth()->toDateString())
        ->get()
        ->pluck('booking_date')
        ->map(fn ($date) => Carbon::parse($date)->day)
        ->unique()
        ->values()
        ->all();
};

$getBuildingBookingDays = function (string $code): array {
    $today = Carbon::today();

    return Booking::query()
        ->whereHas('building', fn ($query) => $query->where('code', strtoupper($code)))
        ->where('status', 'approved')
        ->whereDate('booking_date', '>=', $today->copy()->startOfMonth()->toDateString())
        ->whereDate('booking_date', '<=', $today->copy()->endOfMonth()->toDateString())
        ->get()
        ->pluck('booking_date')
        ->map(fn ($date) => Carbon::parse($date)->day)
        ->unique()
        ->values()
        ->all();
};

Route::get('/', function () {
    return view('home');
});

Route::get('/visi-misi', function () {
    return view('visi-misi');
})->name('visi-misi');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login/mahasiswa', [LoginController::class, 'showMahasiswaLogin'])->name('login.mahasiswa');
Route::get('/login/dosen', [LoginController::class, 'showDosenLogin'])->name('login.dosen');
Route::get('/login/umum', [LoginController::class, 'showUmumLogin'])->name('login.umum');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/profile', [LoginController::class, 'showProfile'])->name('profile');
Route::get('/dashboard/dosen', [LoginController::class, 'showDosenDashboard'])->name('dashboard.dosen');
Route::get('/pilih-gedung', [LoginController::class, 'showBuildingSelection'])->name('building.choose');
Route::get('/gedung-aa', function () use ($getActiveBookingDays) {
    $today = Carbon::today();
    $monthStart = $today->copy()->startOfMonth();
    $daysInMonth = $today->daysInMonth;
    $approvedDays = $getActiveBookingDays();

    return view('auth.building-aa', [
        'today' => $today,
        'monthStart' => $monthStart,
        'daysInMonth' => $daysInMonth,
        'usedDays' => $approvedDays,
        'selectedDay' => 1,
        'selectedDate' => $today->copy()->day(1),
    ]);
})->name('building.aa');
Route::get('/gedung-aa/form/{day}', function (int $day) use ($getActiveBookingDays) {
    $today = Carbon::today();
    $daysInMonth = $today->daysInMonth;
    $usedDays = $getActiveBookingDays();

    abort_if($day < 1 || $day > $daysInMonth, 404);
    abort_if(in_array($day, $usedDays, true), 403);

    return view('auth.building-aa-form', [
        'selectedDay' => $day,
        'selectedDate' => $today->copy()->day($day),
    ]);
})->name('building.aa.form');
Route::post('/gedung-aa/bookings', function (\Illuminate\Http\Request $request) use ($ensureBookingSchema) {
    $ensureBookingSchema();

    $validated = $request->validate([
        'booking_date' => ['required', 'date'],
        'requester_name' => ['required', 'string', 'max:255'],
        'event_name' => ['required', 'string', 'max:255'],
        'time_range' => ['nullable', 'string', 'max:255'],
        'users_count' => ['nullable', 'integer', 'min:1'],
    ]);

    $building = Building::query()->where('code', 'AA')->firstOrFail();

    Booking::create([
        'building_id' => $building->id,
        'booking_date' => $validated['booking_date'],
        'requester_name' => $validated['requester_name'],
        'requester_role' => session('role', 'mahasiswa'),
        'event_name' => $validated['event_name'],
        'time_range' => $validated['time_range'] ?? null,
        'users_count' => $validated['users_count'] ?? null,
        'status' => 'pending',
    ]);

    $bookingDay = Carbon::parse($validated['booking_date'])->day;

    return redirect()
        ->route('building.aa.form', ['day' => $bookingDay])
        ->with('success', 'Oke, Permohonannya Kami proses ya');
})->name('bookings.store');

Route::get('/gedung/{code}', function (string $code) use ($getBuildingBookingDays) {
    $building = Building::query()
        ->active()
        ->where('code', strtoupper($code))
        ->firstOrFail();

    $today = Carbon::today();
    $monthStart = $today->copy()->startOfMonth();
    $daysInMonth = $today->daysInMonth;
    $approvedDays = $getBuildingBookingDays($building->code);

    return view('auth.building-calendar', [
        'building' => $building,
        'today' => $today,
        'monthStart' => $monthStart,
        'daysInMonth' => $daysInMonth,
        'usedDays' => $approvedDays,
        'selectedDay' => 1,
        'selectedDate' => $today->copy()->day(1),
    ]);
})->name('building.show');

Route::get('/gedung/{code}/form/{day}', function (string $code, int $day) use ($getBuildingBookingDays) {
    $building = Building::query()
        ->active()
        ->where('code', strtoupper($code))
        ->firstOrFail();

    $today = Carbon::today();
    $daysInMonth = $today->daysInMonth;
    $usedDays = $getBuildingBookingDays($building->code);

    abort_if($day < 1 || $day > $daysInMonth, 404);
    abort_if(in_array($day, $usedDays, true), 403);

    return view('auth.building-form', [
        'building' => $building,
        'selectedDay' => $day,
        'selectedDate' => $today->copy()->day($day),
    ]);
})->name('building.form');

Route::post('/gedung/{code}/bookings', function (string $code, \Illuminate\Http\Request $request) use ($ensureBookingSchema) {
    $ensureBookingSchema();

    $validated = $request->validate([
        'booking_date' => ['required', 'date'],
        'requester_name' => ['required', 'string', 'max:255'],
        'event_name' => ['required', 'string', 'max:255'],
        'time_range' => ['nullable', 'string', 'max:255'],
        'users_count' => ['nullable', 'integer', 'min:1'],
    ]);

    $building = Building::query()
        ->active()
        ->where('code', strtoupper($code))
        ->firstOrFail();

    Booking::create([
        'building_id' => $building->id,
        'booking_date' => $validated['booking_date'],
        'requester_name' => $validated['requester_name'],
        'requester_role' => session('role', 'mahasiswa'),
        'event_name' => $validated['event_name'],
        'time_range' => $validated['time_range'] ?? null,
        'users_count' => $validated['users_count'] ?? null,
        'status' => 'pending',
    ]);

    $bookingDay = Carbon::parse($validated['booking_date'])->day;

    return redirect()
        ->route('building.form', ['code' => $building->code, 'day' => $bookingDay])
        ->with('success', 'Oke, Permohonannya Kami proses ya');
})->name('bookings.store.building');

$publicFacilityDefinitions = [
    ['code' => 'AUPER', 'name' => 'Aula Pertamina (AUPER)', 'info' => 'Tempat kegiatan dan acara kampus skala besar.'],
    ['code' => 'GRAPOL', 'name' => 'Graha Polinema (Grapol)', 'info' => 'Gedung serbaguna untuk acara resmi dan umum.'],
    ['code' => 'GRATER', 'name' => 'Graha Theater (GRATER)', 'info' => 'Ruang pertunjukan, seminar, dan kegiatan publik.'],
    ['code' => 'MR-DEPAN', 'name' => 'Masjid Raya depan', 'info' => 'Akses tempat ibadah di area depan kampus.'],
    ['code' => 'MR-TENGAH', 'name' => 'Masjid Raya Tengah', 'info' => 'Akses tempat ibadah di area tengah kampus.'],
    ['code' => 'LMS', 'name' => 'Lapangan Mini Soccer', 'info' => 'Area olahraga dan aktivitas fisik.'],
    ['code' => 'LV', 'name' => 'Lapangan Voli', 'info' => 'Area olahraga untuk kegiatan umum.'],
    ['code' => 'LU', 'name' => 'Lapangan Upacara', 'info' => 'Area apel dan kegiatan seremonial kampus.'],
];

$ensurePublicFacilities = function () use ($publicFacilityDefinitions, $ensureBookingSchema): \Illuminate\Support\Collection {
    $ensureBookingSchema();

    foreach ($publicFacilityDefinitions as $facility) {
        Building::query()->updateOrCreate(
            ['code' => $facility['code']],
            [
                'name' => $facility['name'],
                'info' => $facility['info'],
                'kind' => 'facility',
                'is_active' => true,
            ]
        );
    }

    return Building::query()
        ->active()
        ->where('kind', 'facility')
        ->orderBy('name')
        ->get();
};

Route::get('/dashboard/umum', function () use ($ensurePublicFacilities) {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $role = session('role');
    if ($role === 'mahasiswa') {
        return redirect()->route('profile');
    } elseif ($role === 'dosen') {
        return redirect()->route('dashboard.dosen');
    }

    return view('auth.dashboard-umum', [
        'publicFacilities' => $ensurePublicFacilities(),
    ]);
})->name('dashboard.umum');

Route::get('/fasilitas/{code}', function (string $code) use ($ensurePublicFacilities) {
    $facility = $ensurePublicFacilities()->firstWhere('code', strtoupper($code));

    abort_unless($facility, 404);

    $today = Carbon::today();
    $monthStart = $today->copy()->startOfMonth();
    $daysInMonth = $today->daysInMonth;
    $usedDays = Booking::query()
        ->where('building_id', $facility->id)
        ->where('status', 'approved')
        ->whereDate('booking_date', '>=', $today->copy()->startOfMonth()->toDateString())
        ->whereDate('booking_date', '<=', $today->copy()->endOfMonth()->toDateString())
        ->get()
        ->pluck('booking_date')
        ->map(fn ($date) => Carbon::parse($date)->day)
        ->unique()
        ->values()
        ->all();

    return view('auth.facility-calendar', [
        'facility' => $facility,
        'today' => $today,
        'monthStart' => $monthStart,
        'daysInMonth' => $daysInMonth,
        'usedDays' => $usedDays,
        'selectedDay' => 1,
        'selectedDate' => $today->copy()->day(1),
    ]);
})->name('facility.show');

Route::get('/fasilitas/{code}/form/{day}', function (string $code, int $day) use ($ensurePublicFacilities) {
    $facility = $ensurePublicFacilities()->firstWhere('code', strtoupper($code));

    abort_unless($facility, 404);

    $today = Carbon::today();
    $daysInMonth = $today->daysInMonth;
    $usedDays = Booking::query()
        ->where('building_id', $facility->id)
        ->where('status', 'approved')
        ->whereDate('booking_date', '>=', $today->copy()->startOfMonth()->toDateString())
        ->whereDate('booking_date', '<=', $today->copy()->endOfMonth()->toDateString())
        ->get()
        ->pluck('booking_date')
        ->map(fn ($date) => Carbon::parse($date)->day)
        ->unique()
        ->values()
        ->all();

    abort_if($day < 1 || $day > $daysInMonth, 404);
    abort_if(in_array($day, $usedDays, true), 403);

    return view('auth.facility-form', [
        'facility' => $facility,
        'selectedDay' => $day,
        'selectedDate' => $today->copy()->day($day),
    ]);
})->name('facility.form');

Route::post('/fasilitas/{code}/bookings', function (string $code, \Illuminate\Http\Request $request) use ($ensurePublicFacilities, $ensureBookingSchema) {
    $facility = $ensurePublicFacilities()->firstWhere('code', strtoupper($code));

    abort_unless($facility, 404);

    $ensureBookingSchema();

    $validated = $request->validate([
        'booking_date' => ['required', 'date'],
        'requester_name' => ['required', 'string', 'max:255'],
        'event_name' => ['required', 'string', 'max:255'],
        'time_range' => ['nullable', 'string', 'max:255'],
        'users_count' => ['nullable', 'integer', 'min:1'],
    ]);

    Booking::create([
        'building_id' => $facility->id,
        'booking_date' => $validated['booking_date'],
        'requester_name' => $validated['requester_name'],
        'requester_role' => session('role', 'umum'),
        'event_name' => $validated['event_name'],
        'time_range' => $validated['time_range'] ?? null,
        'users_count' => $validated['users_count'] ?? null,
        'status' => 'pending',
    ]);

    return redirect()
        ->route('facility.form', ['code' => $facility->code, 'day' => Carbon::parse($validated['booking_date'])->day])
        ->with('success', 'Oke, Permohonannya Kami proses ya');
})->name('facility.bookings.store');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/pemohon/mahasiswa', [DashboardController::class, 'mahasiswa'])->name('admin.pemohon.mahasiswa');
Route::get('/admin/pemohon/dosen', [DashboardController::class, 'dosen'])->name('admin.pemohon.dosen');
Route::get('/admin/pemohon/umum', [DashboardController::class, 'umum'])->name('admin.pemohon.umum');
Route::get('/admin/pemohon/lainnya', [DashboardController::class, 'lainnya'])->name('admin.pemohon.lainnya');
Route::patch('/admin/bookings/{booking}/approve', [DashboardController::class, 'approve'])->name('admin.bookings.approve');
Route::patch('/admin/bookings/{booking}/reject', [DashboardController::class, 'reject'])->name('admin.bookings.reject');
Route::delete('/admin/bookings/{booking}', [DashboardController::class, 'destroy'])->name('admin.bookings.destroy');
Route::get('/admin/gedung', [BuildingController::class, 'index'])->name('admin.buildings.index');
Route::patch('/admin/gedung/{building}/toggle', [BuildingController::class, 'toggle'])->name('admin.buildings.toggle');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
