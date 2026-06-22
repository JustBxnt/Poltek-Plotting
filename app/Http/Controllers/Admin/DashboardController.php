<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Building;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $buildings = Building::query()
            ->where('kind', 'building')
            ->orderBy('code')
            ->get();
        $bookings = Booking::query()->with('building')->latest()->get();

        return view('admin.dashboard', compact('buildings', 'bookings'));
    }

    public function mahasiswa(): View
    {
        $bookings = Booking::query()->with('building')
            ->where('requester_role', 'mahasiswa')
            ->latest()
            ->get();

        return view('admin.pemohon-mahasiswa', compact('bookings'));
    }

    public function dosen(): View
    {
        $bookings = Booking::query()->with('building')
            ->where('requester_role', 'dosen')
            ->latest()
            ->get();

        return view('admin.pemohon-dosen', compact('bookings'));
    }

    public function umum(): View
    {
        $bookings = Booking::query()->with('building')
            ->where('requester_role', 'umum')
            ->latest()
            ->get();

        return view('admin.pemohon-umum', compact('bookings'));
    }

    public function lainnya(): View
    {
        $bookings = Booking::query()->with('building')
            ->whereNotIn('requester_role', ['mahasiswa', 'dosen', 'umum'])
            ->orWhereNull('requester_role')
            ->latest()
            ->get();

        return view('admin.pemohon-lainnya', compact('bookings'));
    }

    public function approve(Booking $booking): RedirectResponse
    {
        $conflictExists = Booking::query()
            ->where('building_id', $booking->building_id)
            ->whereDate('booking_date', $booking->booking_date)
            ->where('status', 'approved')
            ->whereKeyNot($booking->id)
            ->exists();

        if ($conflictExists) {
            return back()->with('status', 'Tanggal ini sudah dipakai booking lain.');
        }

        $booking->update([
            'status' => 'approved',
        ]);

        return back()->with('status', 'Booking berhasil di-ACC.');
    }

    public function reject(Booking $booking): RedirectResponse
    {
        $booking->update([
            'status' => 'rejected',
        ]);

        return back()->with('status', 'Booking berhasil ditolak.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('status', 'Booking berhasil dihapus.');
    }
}
