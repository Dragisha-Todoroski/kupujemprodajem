@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <h2 class="text-xl font-semibold">Users</h2>
            <p class="text-2xl mt-2">{{ $userCount }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <h2 class="text-xl font-semibold">Ads</h2>
            <p class="text-2xl mt-2">{{ $adCount }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <h2 class="text-xl font-semibold">Categories</h2>
            <p class="text-2xl mt-2">{{ $categoryCount }}</p>
        </div>
    </div>

    {{-- Quick Links to CRUD --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.customers.index') }}" class="bg-blue-500 text-white p-6 rounded-lg text-center hover:bg-blue-600">
            Manage Customers
        </a>
        <a href="{{ route('admin.ads.index') }}" class="bg-purple-500 text-white p-6 rounded-lg text-center hover:bg-purple-600">
            Manage Ads
        </a>
        <a href="{{ route('admin.categories.index') }}" class="bg-green-500 text-white p-6 rounded-lg text-center hover:bg-green-600">
            Manage Categories
        </a>
    </div>

    {{-- Optional: link to frontend view --}}
    <div class="mt-10 text-center">
        <a href="{{ route('ads.index') }}" class="text-blue-600 hover:underline">
            View Home Page
        </a>
    </div>
</div>
@endsection
