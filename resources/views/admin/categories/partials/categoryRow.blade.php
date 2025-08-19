<tr class="hover:bg-gray-50">
    <td class="px-6 py-4">
        {!! str_repeat('&nbsp;&nbsp;', $level) !!}
        @if($level > 0) ↳ @endif {{ $category->name }}
    </td>
    <td class="px-6 py-4">{{ $category->parent?->name ?? '-' }}</td>
    <td class="px-6 py-4">
        <div class="flex items-center justify-center space-x-2">
            <a href="{{ route('admin.categories.edit', $category->getKey()) }}"
               class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                Edit
            </a>
            <form action="{{ route('admin.categories.destroy', $category->getKey()) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </td>
</tr>

@if($category->children)
    @foreach($category->children as $child)
        @include('admin.categories.partials.categoryRow', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif
