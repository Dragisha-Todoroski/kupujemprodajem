@foreach($categories as $category)
    <option value="{{ $category->id }}"
        @if(isset($selected) && $selected == $category->id) selected @endif>
        {!! str_repeat('&nbsp;&nbsp;', $level) !!}↳ {{ $category->name }}
    </option>

    @if($category->children->count())
        @include('admin.categories.partials.categoryOption', [
            'categories' => $category->children,
            'level' => $level + 1,
            'selected' => $selected ?? null
        ])
    @endif
@endforeach
