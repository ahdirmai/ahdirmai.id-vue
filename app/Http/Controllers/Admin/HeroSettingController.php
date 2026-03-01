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
            'cv_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // 10MB max
        ]);

        $hero = HeroSetting::current();
        
        $data = $request->only([
            'role', 'summary_id', 'summary_en', 'focus_text_id', 
            'focus_text_en', 'years_of_experience', 'position_tags'
        ]);

        if ($request->hasFile('cv_file')) {
            if ($hero->cv_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($hero->cv_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($hero->cv_path);
            }
            $data['cv_path'] = $request->file('cv_file')->store('hero', 'public');
        }

        $hero->update($data);

        return back()->with('success', 'Hero settings updated.');
    }
}
