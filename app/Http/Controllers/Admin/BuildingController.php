<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BuildingController extends Controller
{
    public function index(): View
    {
        $buildings = Building::query()
            ->where('kind', 'building')
            ->orderBy('code')
            ->get();

        return view('admin.buildings.index', compact('buildings'));
    }

    public function toggle(Building $building): RedirectResponse
    {
        $building->update([
            'is_active' => ! $building->is_active,
        ]);

        return back()->with('status', 'Status gedung berhasil diperbarui.');
    }
}
