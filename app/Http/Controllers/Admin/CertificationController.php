<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CertificationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/certifications/Index', [
            'certifications' => Certification::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/certifications/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'issued_by' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Certification::create($validated);

        return redirect()->route('admin.certifications.index')->with('success', 'Certification created.');
    }

    public function edit(Certification $certification): Response
    {
        return Inertia::render('admin/certifications/Form', [
            'certification' => $certification,
        ]);
    }

    public function update(Request $request, Certification $certification): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'issued_by' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $certification->update($validated);

        return redirect()->route('admin.certifications.index')->with('success', 'Certification updated.');
    }

    public function destroy(Certification $certification): RedirectResponse
    {
        $certification->delete();

        return back()->with('success', 'Certification deleted.');
    }
}
