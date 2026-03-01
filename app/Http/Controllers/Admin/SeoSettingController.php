<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSetting;
use App\Models\SeoSetting;
use App\Models\TechStack;
use App\Models\WorkExperience;
use App\Services\AiGenerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SeoSettingController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('admin/SeoSetting', [
            'seoSetting' => SeoSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'og_image_file' => ['nullable', 'image', 'max:5120'],
            'favicon_file' => ['nullable', 'image', 'max:2048', 'mimes:ico,png,svg,jpg,jpeg'],
        ]);

        $data = [
            'site_title' => $validated['site_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
        ];

        $seo = SeoSetting::current();

        if ($request->hasFile('og_image_file')) {
            if ($seo->og_image_path && Storage::disk('public')->exists($seo->og_image_path)) {
                Storage::disk('public')->delete($seo->og_image_path);
            }
            $data['og_image_path'] = $request->file('og_image_file')->store('seo', 'public');
        }

        if ($request->hasFile('favicon_file')) {
            if ($seo->favicon_path && Storage::disk('public')->exists($seo->favicon_path)) {
                Storage::disk('public')->delete($seo->favicon_path);
            }
            $data['favicon_path'] = $request->file('favicon_file')->store('seo', 'public');
        }

        $seo->update($data);

        return back()->with('success', 'SEO settings updated.');
    }

    public function generate(Request $request, AiGenerationService $aiService): JsonResponse
    {
        // 1. Gather context
        $hero = HeroSetting::current();
        $experiences = WorkExperience::query()->orderBy('sort_order')->get();
        $techs = TechStack::query()->orderBy('sort_order')->pluck('name')->implode(', ');

        $context = "Role: {$hero->role}\n";
        $context .= "Summary: {$hero->summary_en}\n";
        $context .= "Tech Stack: {$techs}\n";
        $context .= "Experience:\n";
        foreach ($experiences as $exp) {
            $context .= "- {$exp->position} at {$exp->company} ({{$exp->start_date}} to {{$exp->end_date}})\n";
        }

        // 2. Build prompt
        $prompt = <<<PROMPT
You are an expert SEO specialist. Based on the following developer portfolio data, generate optimal SEO metadata:
$context

Please return a valid JSON object strictly matching this schema, without any markdown formatting or code blocks:
{
    "site_title": "string (Max 60 chars. Format: Name | Role or something catchy)",
    "meta_description": "string (Max 160 chars. Compelling summary of skills and experience)",
    "meta_keywords": "string (Comma separated keywords based on tech stack and role, max 10 keywords)"
}
PROMPT;

        try {
            $json = $aiService->generateJson($prompt);

            if (! $json) {
                return response()->json(['error' => 'Failed to parse AI response.'], 500);
            }

            return response()->json($json);
        } catch (\Exception $e) {
            return response()->json(['error' => 'AI Generation failed: '.$e->getMessage()], 500);
        }
    }
}
