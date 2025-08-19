@extends('layouts.app')

@section('title', 'Unauthorized')

@section('content')
<div class="p-6 text-center">
    <h1 class="text-2xl font-bold mb-4">Unauthorized</h1>
    <p class="text-gray-700">Sorry, you do not have permission to access this page.</p>
    <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline mt-4 inline-block">Go Back</a>
</div>
@endsection