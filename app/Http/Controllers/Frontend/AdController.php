<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequests\StoreAdRequest;
use App\Http\Requests\AdRequests\UpdateAdRequest;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Contracts\AdService;
use App\Contracts\CategoryService;

class AdController extends Controller
{
    public function __construct(
        private readonly AdService $adService,
        private readonly CategoryService $categoryService
    ) {
        // Ensures auth for create/edit/delete by customers
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);

        // Applies policy automatically to action methods
        $this->authorizeResource(Ad::class, 'ad');
    }

    /**
     * Display a listing of all (filtered) ads based on search params
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'title',
            'description',
            'min_price',
            'max_price',
            'location',
            'category_id'
        ]);

        $ads = $this->adService->search($filters, 12); // paginate 12 ads per page
        $categories = $this->categoryService->getAll(); // multi-level categories

        return view('frontend.ads.index', compact('ads', 'categories', 'filters'));
    }

    /**
     * Dedicated page for filtered ads by category
     * No other filters applied by default
     */
    public function category(string $categoryId): View
    {
        $category = $this->categoryService->getById($categoryId);

        // Only filter by this category
        $ads = $this->adService->search(['category_id' => $category->getKey()], 12);
        $categories = $this->categoryService->getAll();
        return view('frontend.ads.index', compact('ads', 'categories', 'category'));
    }

    /**
     * Display single ad details
     */
    public function show(string $id): View
    {
        $ad = $this->adService->getById($id);
        $categories = $this->categoryService->getAll();
        return view('frontend.ads.show', compact('ad', 'categories'));
    }

    /**
     * Show the form for creating a new ad
     */
    public function create(): View
    {
        $categories = $this->categoryService->getAll();
        return view('frontend.ads.create', compact('categories'));
    }

    /**
     * Store a newly created ad in storage
     */
    public function store(StoreAdRequest $request): RedirectResponse
    {
        $this->adService->create($request->validated(), $request->file('image'));
        return redirect()->route('frontend.ads.index')->with('success', 'Ad created successfully.');
    }

    /**
     * Show the form for editing the specified ad
     */
    public function edit(Ad $ad): View
    {
        $categories = $this->categoryService->getAll();
        return view('frontend.ads.edit', compact('ad', 'categories'));
    }

    /**
     * Update the specified ad in storage
     */
    public function update(UpdateAdRequest $request, Ad $ad): RedirectResponse
    {
        $this->adService->update($ad, $request->validated(), $request->file('image'));
        return redirect()->route('frontend.ads.show', $ad->getKey())
                        ->with('success', 'Ad updated successfully.');
    }

    /**
     * Remove the specified ad from storage
     */
    public function destroy(Ad $ad): RedirectResponse
    {
        $this->adService->delete($ad);
        return redirect()->route('frontend.ads.index')->with('success', 'Ad deleted successfully.');
    }
}
