<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ContactMessageController extends Controller
{
    /**
     * Store a contact message from the public form.
     * Protected by rate limiting + honeypot field.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Honeypot: if the hidden "website" field is filled, it's a bot
        if ($request->filled('website')) {
            // Silently reject — bots think submission succeeded
            return back();
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
            'recaptcha_token' => ['nullable', 'string'],
        ]);

        $secret = ContactSetting::current()->recaptcha_secret_key;
        if ($secret) {
            if (empty($validated['recaptcha_token'])) {
                throw ValidationException::withMessages(['recaptcha' => 'reCAPTCHA token is missing.']);
            }

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $validated['recaptcha_token'],
                'remoteip' => $request->ip(),
            ]);

            if (! $response->successful() || ! $response->json('success') || $response->json('score') < 0.5) {
                throw ValidationException::withMessages(['recaptcha' => 'reCAPTCHA verification failed. Please try again.']);
            }
        }

        ContactMessage::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', true);
    }
}
