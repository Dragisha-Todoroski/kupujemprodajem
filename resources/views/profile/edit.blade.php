@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            {{-- Only show ads section for customers --}}
            @if(auth()->user()->isCustomer())
                {{-- Button to create a new ad --}}
                <div class="p-4 bg-white shadow sm:rounded-lg inline-block">
                    <a href="{{ route('ads.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Create New Ad
                    </a>
                </div>

                {{-- Customer Ads Section --}}
                @if(auth()->user()->isCustomer() && $ads->count())
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Your Ads</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($ads as $ad)
                                <div class="border rounded-lg shadow p-4 flex flex-col">
                                    @if($ad->image_path)
                                        <img src="{{ asset('storage/' . $ad->image_path) }}"
                                            alt="{{ $ad->title }}"
                                            class="w-full h-40 object-cover rounded mb-2">
                                    @endif
                                    <h4 class="font-bold text-lg mb-2">{{ $ad->title }}</h4>
                                    <p class="text-gray-600 mb-4">{{ Str::limit($ad->description, 50) }}</p>

                                    <div class="mt-auto flex space-x-2">
                                        <a href="{{ route('ads.show', $ad->getKey()) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-700">
                                            View
                                        </a>

                                        <a href="{{ route('ads.edit', $ad->getKey()) }}"
                                        class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('ads.destroy', $ad->getKey()) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
