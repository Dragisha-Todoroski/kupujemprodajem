@extends('layouts.app')

@section('title', 'Create Ad')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6">Create a New Ad</h1>

    @include('partials.adForm', [
        'action' => route('ads.store'),
        'method' => 'POST',
        'ad' => null,
        'leafCategories' => $leafCategories
    ])
</div>
@endsection
