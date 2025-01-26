<div>
    <form wire:submit.prevent="fetchRecipes" class="flex gap-4 w-1/2 my-5">
        <input type="text" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Search recipes..."
            wire:model="query" />

        <x-button type="submit" mode="primary">
            Search
        </x-button>
    </form>

    <div style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));"
        class="grid gap-x-8 gap-y-6 place-items-center">
        @forelse ($recipes as $recipe)
            <a href="{{ route('recipes.show', [$recipe['id']]) }}"
                class='group overflow-hidden select-none max-w-80 pb-3 flex flex-col items-center gap-4 bg-white w-full px-5 rounded-3xl h-full hover:cursor-pointer'>
                <img src="{{ $recipe['image'] ? $recipe['image'] : asset('images/placeholder.jpg') }}"
                    alt="{{ $recipe['title'] }} image"
                    class="rounded-3xl aspect-square w-full transition-transform duration-500 ease-out object-cover group-hover:scale-110" />
                <div class="h-full w-full flex flex-col justify-between">
                    <h2 class="text-[#5B3A1F] text-center font-bold text-xl md:text-2xl">{{ $recipe['title'] }}</h2>
                    <div class="px-3 flex flex-col">
                        <small class="text-semibold text-[#B2794B] text-lg">
                            {{ $recipe['steps'] }} steps
                        </small>
                        <small class="text-semibold text-[#B2794B] text-lg">
                            Estimated time: {{ $recipe['total_time'] }}
                        </small>
                    </div>
                </div>
            </a>
        @empty
            <p>No recipes found.</p>
        @endforelse
    </div>
</div>
