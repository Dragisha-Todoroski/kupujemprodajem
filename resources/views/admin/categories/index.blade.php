@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Page header --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">All Categories</h1>
            <a href="{{ route('admin.categories.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Create New Category
            </a>
        </div>

        {{-- Flash success message --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Categories table --}}
        @if($categories->count())
            <div class="overflow-x-auto bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($categories as $category)
                            @include('admin.categories.partials.categoryRow', ['category' => $category, 'level' => 0])
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="p-4">
                    {{ $categories->links() }}
                </div>
            </div>
        @else
            <div class="p-4 bg-white shadow sm:rounded-lg">
                No categories found.
            </div>
        @endif
    </div>
</div>
@endsection
