<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyHuman
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip verification check for:
        // - The bot-check page
        // - POST request to verify
        // - Authenticated admin users
        if ($request->path() === 'bot-check' || 
            ($request->isMethod('post') && $request->path() === 'verify') ||
            ($request->user() && $request->user()->is_admin)) {
            return $next($request);
        }

        // Check if user has verified they're human in this session
        if (!session()->has('human_verified')) {
            return redirect()->route('bot-check');
        }

        return $next($request);
    }
}
