<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DashboardRedirectController extends Controller
{
    /**
     * Redirect users to the appropriate dashboard based on their role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        if ($request->user() && $request->user()->is_admin) {
            // If the user is an admin, redirect to admin dashboard
            return Redirect::route('admin.dashboard');
        }
        
        // Otherwise, redirect to regular customer dashboard
        return Redirect::route('dashboard');
    }
}