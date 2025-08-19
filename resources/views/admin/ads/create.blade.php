@extends('layouts.app')

@section('title', 'Create New Ad')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Create New Ad</h1>

        @include('partials.adForm', [
            'action' => route('admin.ads.store'),
            'method' => 'POST',
            'ad' => null
        ])
    </div>
</div>
@endsection
