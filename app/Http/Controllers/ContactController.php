<?php

namespace App\Http\Controllers;

use App\Mail\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function index()
    {
        return Inertia::render('Contact');
    }

    /**
     * Handle the contact form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            // Send email to support
            Mail::to(config('mail.support_email', 'support@fieldengineerpro.com'))
                ->send(new SupportRequest(
                    $validated['name'],
                    $validated['email'],
                    $validated['subject'],
                    $validated['message']
                ));

            return back()->with('success', 'Thank you for contacting us! We\'ll get back to you as soon as possible.');
        } catch (\Exception $e) {
            \Log::error('Failed to send support email: ' . $e->getMessage());
            return back()->with('error', 'Sorry, there was an error sending your message. Please try again or email us directly at support@fieldengineerpro.com');
        }
    }
}
