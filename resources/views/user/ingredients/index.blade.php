<x-site-layout>
    <h1 class="text-4xl font-bold text-center text-[#5B3A1F] mt-5">
        Ingredients
    </h1>
    <div class="w-full flex justify-end">
        @if(auth()->user() !== null)
            <x-link mode="secondary" href="{{ route('user.ingredients.create') }}">
                New ingredient
            </x-link>
        @endif
    </div>
    <div style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));"
        class="mt-3 mb-10 grid gap-x-8 gap-y-6 place-items-center">
        @foreach ($ingredients as $ingredient)
            <article
                class="group h-auto overflow-hidden select-none pb-3 flex flex-col items-center gap-4 bg-white w-full px-5 rounded-3xl transition-transform duration-300 ease-out hover:scale-105">
                <img src="{{$ingredient->image}}" alt="{{$ingredient->name}} image"
                    class="rounded-3xl h-32 transition-transform duration-300 ease-out md:h-40 group-hover:scale-105" />
                <div class="h-full w-full flex flex-col justify-between">
                    <h2 class="text-[#5B3A1F] text-center font-bold text-base md:text-xl">{{ $ingredient->name }}</h2>
                </div>
            </article>
        @endforeach
    </div>

</x-site-layout>