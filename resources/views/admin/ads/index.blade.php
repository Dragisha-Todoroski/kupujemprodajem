@extends('layouts.app')

@section('title', 'All Ads')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Page header --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">All Ads</h1>
            <a href="{{ route('admin.ads.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Create New Ad
            </a>
        </div>

        {{-- Flash success message --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ads table --}}
        @if($ads->count())
            <div class="overflow-x-auto bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($ads as $ad)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if($ad->image_path)
                                        <img src="{{ asset('storage/' . $ad->image_path) }}"
                                             alt="{{ $ad->title }}"
                                             class="w-16 h-16 object-cover rounded">
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ Str::limit($ad->title, 30) }}</td>
                                <td class="px-6 py-4">${{ number_format($ad->price, 2) }}</td>
                                <td class="px-6 py-4">{{ $ad->category?->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ ucfirst($ad->condition?->value ?? '-') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('ads.show', $ad->getKey()) }}"
                                           class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-700">
                                            View
                                        </a>
                                        <a href="{{ route('admin.ads.edit', $ad->getKey()) }}"
                                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.ads.destroy', $ad->getKey()) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="p-4">
                    {{ $ads->links() }}
                </div>
            </div>
        @else
            <div class="p-4 bg-white shadow sm:rounded-lg">
                No ads found.
            </div>
        @endif
    </div>
</div>
@endsection
