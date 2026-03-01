<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HeroSettingController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('admin/HeroSetting', [
            'heroSetting' => HeroSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'summary_id' => ['required', 'string'],
            'summary_en' => ['required', 'string'],
            'focus_text_id' => ['required', 'string', 'max:255'],
            'focus_text_en' => ['required', 'string', 'max:255'],
            'years_of_experience' => ['required', 'integer', 'min:0'],
            'position_tags' => ['nullable', 'array'],
            'position_tags.*' => ['string'],
        ]);

        HeroSetting::current()->update($validated);

        return back()->with('success', 'Hero settings updated.');
    }
}
