<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrganizationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/organizations/Index', [
            'organizations' => Organization::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/organizations/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Organization::create($validated);

        return redirect()->route('admin.organizations.index')->with('success', 'Organization created.');
    }

    public function edit(Organization $organization): Response
    {
        return Inertia::render('admin/organizations/Form', [
            'organization' => $organization,
        ]);
    }

    public function update(Request $request, Organization $organization): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $organization->update($validated);

        return redirect()->route('admin.organizations.index')->with('success', 'Organization updated.');
    }

    public function destroy(Organization $organization): RedirectResponse
    {
        $organization->delete();

        return back()->with('success', 'Organization deleted.');
    }
}
