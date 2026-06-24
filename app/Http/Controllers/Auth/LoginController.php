<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showMahasiswaLogin()
    {
        return view('auth.login-mahasiswa');
    }

    public function showDosenLogin()
    {
        return view('auth.login-dosen');
    }

    public function showUmumLogin()
    {
        return view('auth.login-umum');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:mahasiswa,dosen,umum',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->session()->put('role', $request->input('role'));

            return match ($request->input('role')) {
                'dosen' => redirect()->intended(route('dashboard.dosen')),
                'mahasiswa' => redirect()->intended(route('profile')),
                default => redirect()->intended(route('dashboard.umum')),
            };
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function showProfile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = session('role');
        if ($role === 'dosen') {
            return redirect()->route('dashboard.dosen');
        } elseif ($role === 'umum') {
            return redirect()->route('dashboard.umum');
        }

        return view('auth.profile');
    }

    public function showDosenDashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = session('role');
        if ($role === 'mahasiswa') {
            return redirect()->route('profile');
        } elseif ($role === 'umum') {
            return redirect()->route('dashboard.umum');
        }

        return view('auth.dashboard-dosen');
    }

    public function showUmumDashboard()
    {
        return view('auth.dashboard-umum');
    }

    public function showBuildingSelection()
    {
        $buildings = Building::query()
            ->active()
            ->where('kind', 'building')
            ->orderBy('code')
            ->get();

        return view('auth.choose-building', compact('buildings'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}