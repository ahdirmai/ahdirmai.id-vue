<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EducationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/educations/Index', [
            'educations' => Education::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/educations/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'university' => ['required', 'string', 'max:255'],
            'degree_id' => ['required', 'string', 'max:255'],
            'degree_en' => ['required', 'string', 'max:255'],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'awards' => ['nullable', 'array'],
            'awards.*' => ['string'],
            'research_title' => ['nullable', 'string', 'max:255'],
            'research_link' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Education::create($validated);

        return redirect()->route('admin.educations.index')->with('success', 'Education created.');
    }

    public function edit(Education $education): Response
    {
        return Inertia::render('admin/educations/Form', [
            'education' => $education,
        ]);
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $validated = $request->validate([
            'university' => ['required', 'string', 'max:255'],
            'degree_id' => ['required', 'string', 'max:255'],
            'degree_en' => ['required', 'string', 'max:255'],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'awards' => ['nullable', 'array'],
            'awards.*' => ['string'],
            'research_title' => ['nullable', 'string', 'max:255'],
            'research_link' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $education->update($validated);

        return redirect()->route('admin.educations.index')->with('success', 'Education updated.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->delete();

        return back()->with('success', 'Education deleted.');
    }
}
