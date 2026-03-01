<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TechStack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TechStackController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/tech-stacks/Index', [
            'techStacks' => TechStack::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/tech-stacks/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        TechStack::create($validated);

        return redirect()->route('admin.tech-stacks.index')->with('success', 'Tech stack created.');
    }

    public function edit(TechStack $techStack): Response
    {
        return Inertia::render('admin/tech-stacks/Form', [
            'techStack' => $techStack,
        ]);
    }

    public function update(Request $request, TechStack $techStack): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $techStack->update($validated);

        return redirect()->route('admin.tech-stacks.index')->with('success', 'Tech stack updated.');
    }

    public function destroy(TechStack $techStack): RedirectResponse
    {
        $techStack->delete();

        return back()->with('success', 'Tech stack deleted.');
    }
}
