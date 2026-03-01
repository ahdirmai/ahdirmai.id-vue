<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WorkExperienceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/work-experiences/Index', [
            'workExperiences' => WorkExperience::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/work-experiences/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description_id' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        WorkExperience::create($validated);

        return redirect()->route('admin.work-experiences.index')->with('success', 'Work experience created.');
    }

    public function edit(WorkExperience $workExperience): Response
    {
        return Inertia::render('admin/work-experiences/Form', [
            'workExperience' => $workExperience,
        ]);
    }

    public function update(Request $request, WorkExperience $workExperience): RedirectResponse
    {
        $validated = $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description_id' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $workExperience->update($validated);

        return redirect()->route('admin.work-experiences.index')->with('success', 'Work experience updated.');
    }

    public function destroy(WorkExperience $workExperience): RedirectResponse
    {
        $workExperience->delete();

        return back()->with('success', 'Work experience deleted.');
    }
}
