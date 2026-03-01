<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/portfolios/Index', [
            'portfolios' => Portfolio::query()->with('images')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/portfolios/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'category' => ['required', 'string', 'in:public,private'],
            'live_preview_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'stacks' => ['nullable', 'array'],
            'stacks.*' => ['string'],
            'key_features' => ['nullable', 'array'],
            'key_features.*' => ['string'],
            'sort_order' => ['nullable', 'integer'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'], // 5MB max per image
        ]);

        $portfolio = Portfolio::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('portfolios', 'public');
                $portfolio->images()->create([
                    'image_path' => $path,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio created.');
    }

    public function edit(Portfolio $portfolio): Response
    {
        return Inertia::render('admin/portfolios/Form', [
            'portfolio' => $portfolio->load('images'),
        ]);
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'category' => ['required', 'string', 'in:public,private'],
            'live_preview_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'stacks' => ['nullable', 'array'],
            'stacks.*' => ['string'],
            'key_features' => ['nullable', 'array'],
            'key_features.*' => ['string'],
            'sort_order' => ['nullable', 'integer'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'deleted_images' => ['nullable', 'array'],
            'deleted_images.*' => ['integer'],
        ]);

        $portfolio->update($validated);

        // Delete removed images
        if (!empty($validated['deleted_images'])) {
            $imagesToDelete = $portfolio->images()->whereIn('id', $validated['deleted_images'])->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            $maxOrder = $portfolio->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $file) {
                $maxOrder++;
                $path = $file->store('portfolios', 'public');
                $portfolio->images()->create([
                    'image_path' => $path,
                    'sort_order' => $maxOrder,
                ]);
            }
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio updated.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $portfolio->delete();

        return back()->with('success', 'Portfolio deleted.');
    }
}
