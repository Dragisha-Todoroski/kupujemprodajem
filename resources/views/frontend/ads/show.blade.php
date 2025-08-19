@extends('layouts.app')

@section('title', $ad->title)

@section('content')
<div class="flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white p-4 shadow">
        <h3 class="text-lg font-bold mb-4">Categories</h3>
        @include('frontend.partials.categoriesSidebar', ['categories' => $categories])
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        {{-- Back Button --}}
        <a href="{{ route('ads.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">&larr; Back to Ads</a>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            @if ($ad->image_path)
                <img src="{{ asset('storage/' . $ad->image_path) }}"
                    alt="{{ $ad->title }}"
                    class="w-1/4 h-auto rounded-lg mb-4 mr-4 float-left">
            @endif

                {{-- Basic Info --}}
                <h1 class="text-3xl font-bold mb-2">{{ $ad->title }}</h1>
                <p class="text-gray-600 mb-4">{{ $ad->description }}</p>

                {{-- Key Details --}}
                <div class="flex flex-wrap gap-4 mb-4 text-gray-700">
                    <span class="font-semibold">Price:</span> ${{ $ad->price }}
                    <span class="font-semibold">Location:</span> {{ $ad->location }}
                    <span class="font-semibold">Category:</span> {{ $ad->category->name ?? '-' }}
                    <span class="font-semibold">Condition:</span> {{ ucfirst($ad->condition->value) }}
                    <span class="font-semibold">Posted:</span> {{ $ad->created_at->format('M d, Y') }}
                    <span class="font-semibold">Last Updated:</span> {{ $ad->updated_at->format('M d, Y') }}
                </div>

                {{-- Seller Info --}}
                <div class="mt-6">
                    <h2 class="text-lg font-semibold mb-2">Seller Information</h2>
                    <p class="text-gray-700">Name: {{ $ad->user->name }}</p>
                    <p class="text-gray-700">
                        Email: <a href="mailto:{{ $ad->user->email }}" class="text-blue-600 hover:underline">{{ $ad->user->email }}</a>
                    </p>
                    {{-- Phone number is specific to ad, not user, for flexibility --}}
                    <p class="text-gray-700">Phone: {{ $ad->contact_phone }}</p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
