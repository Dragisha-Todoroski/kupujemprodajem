<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Contracts\AdService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdController extends Controller
{
    public function __construct(private readonly AdService $adService) {
        // Only authenticated users can access these routes
        $this->middleware(['auth', 'is_admin']);

        // Applies policy automatically to action methods
        $this->authorizeResource(Ad::class, 'ad');
    }

    /**
     * Display all ads in admin dashboard
     */
    public function index(): View
    {
        $ads = $this->adService->getAll(12);
        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new ad
     */
    public function create(): View
    {
        $categories = $this->categoryService->getAll();
        return view('admin.ads.create', compact('categories'));
    }

    /**
     * Store a newly created ad in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $this->adService->create($request->validated(), $request->file('image'));
        return redirect()->route('admin.ads.index')
                         ->with('success', 'Ad created successfully.');
    }

    /**
     * Show the form for editing any a specific ad (admins can edit any ad)
     */
    public function edit(Ad $ad): View
    {
        $categories = $this->categoryService->getAll();
        return view('admin.ads.edit', compact('ad', 'categories'));
    }

    /**
     * Update the specified ad in storage (admins can update any ad)
     */
    public function update(Request $request, Ad $ad): RedirectResponse
    {
        $this->adService->update($ad, $request->validated(), $request->file('image'));
        return redirect()->route('admin.ads.index')
                         ->with('success', 'Ad updated successfully.');
    }

    /**
     * Remove the specified ad from storage (admins can delete any ad)
     */
    public function destroy(Ad $ad): RedirectResponse
    {
        $this->adService->delete($ad);
        return redirect()->route('admin.ads.index')
                         ->with('success', 'Ad deleted successfully.');
    }
}
