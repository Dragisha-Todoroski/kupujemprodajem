<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequests\StoreCategoryRequest;
use App\Http\Requests\CategoryRequests\UpdateCategoryRequest;
use App\Models\Category;
use App\Contracts\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService) {}

    /**
     * Display all ads in admin dashboard
     */
    public function index(): View
    {
        $categories = $this->categoryService->getAllPaginated(4);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create(): View
    {
        $categories = $this->categoryService->getAll();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created category in storage
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create($request->validated());
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category): View
    {
        $categories = $this->categoryService->getAll();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified category in storage
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->categoryService->update($category, $request->validated());
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->delete($category);
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
