@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
<div class="py-12">
    <div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg">
        <h1 class="text-xl font-bold mb-4">Create Customer</h1>

        {{-- Flash success or error message --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-100 text-red-800 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.customers.store') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-gray-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border px-3 py-2 rounded" maxlength="255">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border px-3 py-2 rounded" maxlength="255">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password"
                       class="w-full border px-3 py-2 rounded" minlength="6">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div class="mb-4">
                <label class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border px-3 py-2 rounded" minlength="6">
            </div>

            {{-- Submit --}}
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create Customer
            </button>
        </form>
    </div>
</div>
@endsection