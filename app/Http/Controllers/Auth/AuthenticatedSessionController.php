<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        if (Auth::check() && !$request->has('add_account')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $active = $request->session()->get('active_accounts', []);
        $userId = Auth::id();
        if (!in_array($userId, $active)) {
            $active[] = $userId;
            $request->session()->put('active_accounts', $active);
        }

        return redirect()->route('dashboard', ['authuser' => $userId]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $currentId = $request->query('authuser', Auth::id());
        $active = $request->session()->get('active_accounts', []);
        
        // Buang akun saat ini dari daftar
        $active = array_filter($active, fn($id) => $id != $currentId);
        $active = array_values($active); // Reset index
        
        if (count($active) > 0) {
            $nextId = $active[0];
            $request->session()->put('active_accounts', $active);
            Auth::loginUsingId($nextId);
            return redirect()->route('dashboard', ['authuser' => $nextId]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
