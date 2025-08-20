@extends('layouts.app')

@section('title', 'All Ads')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white p-6 shadow-md">
        <h3 class="text-xl font-bold mb-6">Categories</h3>
        @include('frontend.partials.categoriesSidebar', ['categories' => $categories])
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6 space-y-6">
        {{-- Search / Filter Form --}}
        <form method="GET" action="{{ route('ads.index') }}" class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 items-end">
                <input type="text" name="title" placeholder="Title" value="{{ $filters['title'] ?? '' }}"
                       class="border rounded-md p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <input type="text" name="description" placeholder="Description" value="{{ $filters['description'] ?? '' }}"
                       class="border rounded-md p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <input type="text" name="location" placeholder="Location" value="{{ $filters['location'] ?? '' }}"
                       class="border rounded-md p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <input type="number" name="min_price" placeholder="Min Price" value="{{ $filters['min_price'] ?? '' }}"
                       class="border rounded-md p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <input type="number" name="max_price" placeholder="Max Price" value="{{ $filters['max_price'] ?? '' }}"
                       class="border rounded-md p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <select name="category_id" class="border rounded-md p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">All Categories</option>
                    @foreach ($leafCategories as $category)
                        <option value="{{ $category->getKey() }}"
                            {{ isset($filters['category_id']) && $filters['category_id'] == $category->getKey() ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sorting + Filter Button --}}
            <div class="flex flex-col sm:flex-row gap-4 mt-4 items-end">
                <select name="sort_by" class="border rounded-md p-2 w-full sm:w-48 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">Sort By</option>
                    <option value="title" {{ ($filters['sort_by'] ?? '') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="price" {{ ($filters['sort_by'] ?? '') == 'price' ? 'selected' : '' }}>Price</option>
                    <option value="condition" {{ ($filters['sort_by'] ?? '') == 'condition' ? 'selected' : '' }}>Condition</option>
                    <option value="created_at" {{ ($filters['sort_by'] ?? '') == 'created_at' ? 'selected' : '' }}>Date</option>
                </select>

                <select name="sort_order" class="border rounded-md p-2 w-full sm:w-32 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="asc" {{ ($filters['sort_order'] ?? '') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ ($filters['sort_order'] ?? '') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition w-full sm:w-auto">
                    Filter
                </button>
            </div>
        </form>

        {{-- Ads Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($ads as $ad)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden cursor-pointer flex flex-col"
                     onclick="window.location='{{ route('ads.show', $ad->getKey()) }}'">
                    @if ($ad->image_path)
                        <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="w-full h-52 object-cover">
                    @endif
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-lg mb-2">{{ $ad->title }}</h3>
                        <p class="text-gray-600 mb-2 flex-1">{{ Str::limit($ad->description, 80) }}</p>
                        <p class="font-semibold mb-1">Price: ${{ $ad->price }}</p>
                        <p class="text-sm text-gray-500">Location: {{ $ad->location }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-full text-gray-500">No ads found.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $ads->withQueryString()->links() }}
        </div>
    </main>
</div>
@endsection