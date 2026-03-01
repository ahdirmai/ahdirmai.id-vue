<?php

use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\HeroSettingController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\TechStackController;
use App\Http\Controllers\Admin\WorkExperienceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Settings (single-row)
    Route::get('hero', [HeroSettingController::class, 'edit'])->name('hero.edit');
    Route::put('hero', [HeroSettingController::class, 'update'])->name('hero.update');

    Route::get('contact', [ContactSettingController::class, 'edit'])->name('contact.edit');
    Route::put('contact', [ContactSettingController::class, 'update'])->name('contact.update');

    Route::get('seo', [SeoSettingController::class, 'edit'])->name('seo.edit');
    Route::put('seo', [SeoSettingController::class, 'update'])->name('seo.update');
    Route::post('seo/generate', [SeoSettingController::class, 'generate'])->name('seo.generate');

    // CRUD resources
    Route::resource('work-experiences', WorkExperienceController::class)->except('show');
    Route::resource('educations', EducationController::class)->except('show');
    Route::resource('organizations', OrganizationController::class)->except('show');
    Route::resource('certifications', CertificationController::class)->except('show');
    Route::resource('tech-stacks', TechStackController::class)->except('show');
    Route::resource('portfolios', PortfolioController::class)->except('show');

    // Messages
    Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'destroy'])->names('messages');
});
