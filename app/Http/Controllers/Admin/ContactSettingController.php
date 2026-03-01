<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactSettingController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('admin/ContactSetting', [
            'contactSetting' => ContactSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['nullable', 'email', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'recaptcha_site_key' => ['nullable', 'string', 'max:255'],
            'recaptcha_secret_key' => ['nullable', 'string', 'max:255'],
        ]);

        ContactSetting::current()->update($validated);

        return back()->with('success', 'Contact settings updated.');
    }
}
