@extends('layouts.app')

@section('title', 'Edit Ad: ' . $ad->title)

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6">Edit Ad</h1>

    @include('partials.adForm', [
        'action' => route('ads.update', $ad->getKey()),
        'method' => 'PUT',
        'ad' => $ad,
        'leafCategories' => $leafCategories
    ])
</div>
@endsection
