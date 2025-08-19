<!-- views/partials/adForm.blade.php -->

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <!-- Title -->
    <div class="mb-4">
        <label for="title" class="block text-gray-700 font-semibold mb-1">Title</label>
        <input type="text" name="title" id="title"
               class="w-full border rounded p-2 @error('title') border-red-500 @enderror"
               value="{{ old('title', $ad->title ?? '') }}">
        @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label for="description" class="block text-gray-700 font-semibold mb-1">Description</label>
        <textarea name="description" id="description" rows="5"
                  class="w-full border rounded p-2 @error('description') border-red-500 @enderror">{{ old('description', $ad->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Price -->
    <div class="mb-4">
        <label for="price" class="block text-gray-700 font-semibold mb-1">Price</label>
        <input type="number" name="price" id="price"
               class="w-full border rounded p-2 @error('price') border-red-500 @enderror"
               value="{{ old('price', $ad->price ?? '') }}" step="0.01">
        @error('price')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Condition -->
    <div class="mb-4">
        <label for="condition" class="block text-gray-700 font-semibold mb-1">Condition</label>
        <select id="condition" name="condition"
                class="w-full border rounded p-2 @error('condition') border-red-500 @enderror">
            <option value="">Select condition</option>
            <option value="new" {{ old('condition', $ad->condition->value ?? '') == 'new' ? 'selected' : '' }}>New</option>
            <option value="used" {{ old('condition', $ad->condition->value ?? '') == 'used' ? 'selected' : '' }}>Used</option>
        </select>
        @error('condition')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Image -->
    <div class="mb-4">
        <label for="image" class="block text-gray-700 font-semibold mb-1">Upload Image</label>
        @if(!empty($ad->image_path))
            <img src="{{ asset('storage/' . $ad->image_path) }}" alt="Current Image" class="w-48 h-auto mb-2 rounded border">
        @endif
        <input type="file" name="image" id="image" class="w-full border rounded p-2 @error('image') border-red-500 @enderror">
        @error('image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Contact Phone -->
    <div class="mb-4">
        <label for="contact_phone" class="block text-gray-700 font-semibold mb-1">Contact Phone</label>
        <input type="text" name="contact_phone" id="contact_phone"
               class="w-full border rounded p-2 @error('contact_phone') border-red-500 @enderror"
               value="{{ old('contact_phone', $ad->contact_phone ?? '') }}">
        @error('contact_phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Location -->
    <div class="mb-4">
        <label for="location" class="block text-gray-700 font-semibold mb-1">Location</label>
        <input type="text" name="location" id="location"
               class="w-full border rounded p-2 @error('location') border-red-500 @enderror"
               value="{{ old('location', $ad->location ?? '') }}">
        @error('location')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Category -->
    <div class="mb-4">
        <label for="category_id" class="block text-gray-700 font-semibold mb-1">Category</label>
        <select name="category_id" id="category_id"
                class="w-full border rounded p-2 @error('category_id') border-red-500 @enderror">
            <option value="">Select category</option>
            @foreach ($leafCategories as $category)
                <option value="{{ $category->getKey() }}" {{ old('category_id', $ad->category_id ?? '') == $category->getKey() ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="mt-6">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ $ad ? 'Update Ad' : 'Create Ad' }}
        </button>
    </div>
</form>
