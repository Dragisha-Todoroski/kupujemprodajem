@extends('layouts.app')

@section('title', 'All Customers')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Page header --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">All Customers</h1>
            <a href="{{ route('admin.customers.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Create New Customer
            </a>
        </div>

        {{-- Flash success message --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Customers table --}}
        @if($customers->count())
            <div class="overflow-x-auto bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ads</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->ads_count }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.customers.edit', $customer->getKey()) }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.customers.destroy', $customer->getKey()) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="p-4">
                    {{ $customers->links() }}
                </div>
            </div>
        @else
            <div class="p-4 bg-white shadow sm:rounded-lg">
                No customers found.
            </div>
        @endif
    </div>
</div>
@endsection
