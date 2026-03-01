<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\ContactSetting;
use App\Models\Education;
use App\Models\HeroSetting;
use App\Models\Organization;
use App\Models\Portfolio;
use App\Models\SeoSetting;
use App\Models\TechStack;
use App\Models\WorkExperience;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Welcome', [
            'hero' => HeroSetting::current(),
            'workExperiences' => WorkExperience::query()->orderBy('sort_order')->get(),
            'educations' => Education::query()->orderBy('sort_order')->get(),
            'organizations' => Organization::query()->orderBy('sort_order')->get(),
            'certifications' => Certification::query()->orderBy('sort_order')->get(),
            'techStacks' => TechStack::query()->orderBy('sort_order')->get(),
            'portfolios' => Portfolio::query()
                ->with('images')
                ->where('category', 'public')
                ->orderBy('sort_order')
                ->get(),
            'contact' => ContactSetting::current(),
            'seo' => SeoSetting::current(),
        ]);
    }
}
