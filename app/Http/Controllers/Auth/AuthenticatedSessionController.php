<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if the authenticated user is an admin
        if ($request->user() && $request->user()->is_admin === true) {
            return redirect()->intended('/admin/dashboard');
        }

        // Redirect to loading screen which will then redirect to dashboard
        return redirect()->intended('/loading');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Preserve the human verification across logout
        $wasVerified = $request->session()->get('human_verified');
        
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        // Restore the verification status so they don't have to verify again
        if ($wasVerified) {
            $request->session()->put('human_verified', true);
        }

        return redirect('/');
    }
}
