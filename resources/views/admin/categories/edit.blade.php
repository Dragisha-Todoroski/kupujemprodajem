@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="py-12">
    <div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg">
        <h1 class="text-xl font-bold mb-4">Edit Category</h1>

        <form action="{{ route('admin.categories.update', $category->getKey()) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-gray-700">Category Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $category->name) }}"
                       class="w-full border px-3 py-2 rounded" required maxlength="100">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Parent Category --}}
            <div class="mb-4">
                <label class="block text-gray-700">Parent Category</label>
                <select name="parent_id" class="w-full border px-3 py-2 rounded">
                    <option value="">-- None --</option>
                    @foreach($categories as $loopCategory)
                        <option value="{{ $loopCategory->getKey() }}"
                            @if(old('parent_id', $category->parent_id) == $loopCategory->getKey()) selected @endif>
                            {{ $loopCategory->name }}
                        </option>

                        @if($loopCategory->children->count())
                            @include('admin.categories.partials.categoryOption', [
                                'categories' => $loopCategory->children,
                                'level' => 1,
                                'selected' => old('parent_id', $category->parent_id)
                            ])
                        @endif
                    @endforeach
                </select>
                @error('parent_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update Category
            </button>
        </form>
    </div>
</div>
@endsection
