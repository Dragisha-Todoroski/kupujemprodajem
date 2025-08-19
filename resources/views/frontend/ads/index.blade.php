@extends('layouts.app')

@section('title', 'All Ads')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white p-4 shadow">
        <h3 class="text-lg font-bold mb-4">Categories</h3>
        @include('frontend.partials.categoriesSidebar', ['categories' => $categories])
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        {{-- Search / Filter Form --}}
        <form method="GET" action="{{ route('ads.index') }}" class="mb-6 p-4 bg-white rounded shadow">
            <div class="grid grid-cols-1 sm:grid-cols-5 gap-4 items-end">
                <input type="text" name="title" placeholder="Title" value="{{ $filters['title'] ?? '' }}" class="border rounded p-2 w-full">
                <input type="text" name="description" placeholder="Description" value="{{ $filters['description'] ?? '' }}" class="border rounded p-2 w-full">
                <input type="text" name="location" placeholder="Location" value="{{ $filters['location'] ?? '' }}" class="border rounded p-2 w-full">
                <input type="number" name="min_price" placeholder="Min price" value="{{ $filters['min_price'] ?? '' }}" class="border rounded p-2 w-full">
                <input type="number" name="max_price" placeholder="Max price" value="{{ $filters['max_price'] ?? '' }}" class="border rounded p-2 w-full">
                <select name="category_id" class="border rounded p-2 w-full">
                    <option value="">All Categories</option>
                    @foreach ($leafCategories as $category)
                        <option value="{{ $category->getKey() }}"
                            {{ isset($filters['category_id']) && $filters['category_id'] == $category->getKey() ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="w-full">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition w-full">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        {{-- Ads --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($ads as $ad)
                <div class="border rounded-lg shadow hover:shadow-lg transition overflow-hidden bg-white flex flex-col cursor-pointer"
                    onclick="window.location='{{ route('ads.show', $ad->getKey()) }}'">
                    @if ($ad->image_path)
                        <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-lg mb-1">{{ $ad->title }}</h3>
                        <p class="text-gray-600 mb-2 flex-1">{{ Str::limit($ad->description, 60) }}</p>
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
