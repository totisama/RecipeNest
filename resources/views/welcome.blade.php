<x-site-layout>
    <h1 class="text-5xl font-bold text-center text-[#5B3A1F]">
        Recipes
    </h1>
    <div style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));"
        class="px-5 mt-5 mb-10 grid gap-x-8 gap-y-6 place-items-center">
        @foreach ($recipes as $recipe)
            <a href="{{ route('recipes.show', [$recipe->id]) }}"
                class='group overflow-hidden select-none max-w-80 pb-3 flex flex-col items-center gap-4 bg-white w-full px-5 rounded-3xl h-full hover:cursor-pointer'>
                <img src="{{ $recipe->media->first() !== null ? $recipe->media->first()->getUrl() : asset('images/placeholder.jpg') }}"
                    alt="{{ $recipe->title }} image"
                    class="rounded-3xl h-48 transition-transform duration-500 ease-in-out md:h-56 group-hover:scale-110" />
                <div class="h-full w-full flex flex-col justify-between">
                    <h2 class="text-[#5B3A1F] text-center font-bold text-xl md:text-2xl">{{ $recipe->title }}</h2>
                    <div class="px-3 flex flex-col">
                        <small class="text-semibold text-[#B2794B] text-lg">
                            {{ count($recipe->steps) }} steps
                        </small>
                        <small class="text-semibold text-[#B2794B] text-lg">
                            Estimated time: {{ $recipe->formatTime() }}
                        </small>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-site-layout>
