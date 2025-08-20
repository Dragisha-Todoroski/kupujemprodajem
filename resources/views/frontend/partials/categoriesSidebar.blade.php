@php
    // Split categories into ones with children and leaf categories (no children)
    $withChildren = $categories->filter(fn($category) => $category->children->count());
    $leaves = $categories->filter(fn($category) => !$category->children->count());
@endphp

<ul class="space-y-1">
    {{-- Categories with children first --}}
    @foreach ($withChildren as $category)
        <li>
            <div x-data="categoryItem('{{ $category->getKey() }}')" class="flex flex-col">
                <button @click="toggle"
                    class="flex justify-between items-center w-full text-left font-semibold px-2 py-1 rounded bg-gray-100 hover:text-blue-600 focus:outline-none transition">
                    {{ $category->name }}
                    <span x-show="!open">+</span>
                    <span x-show="open">−</span>
                </button>

                <ul x-show="open" class="ml-4 mt-1 space-y-1">
                    @include('frontend.partials.categoriesSidebar', [
                        'categories' => $category->children
                    ])
                </ul>
            </div>
        </li>
    @endforeach

    {{-- Leaf categories at the bottom --}}
    @foreach ($leaves as $category)
        <li>
            <a href="{{ route('ads.category', $category->getKey()) }}"
               class="block pl-6 pr-2 py-1 text-gray-700 hover:text-blue-600 bg-gray-50 rounded transition">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
</ul>


{{-- Each category's open/collapsed state is saved in LocalStorage --}}
<script>
    function categoryItem(id) {
        return {
            open: JSON.parse(localStorage.getItem('category-' + id)) || false,
            toggle() {
                this.open = !this.open;
                localStorage.setItem('category-' + id, JSON.stringify(this.open));
            }
        }
    }
</script>