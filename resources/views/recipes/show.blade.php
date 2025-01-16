<x-site-layout>
    <x-back-button route="{{ route('welcome') }}" />
    <div class="max-w-5xl mx-auto px-6 pt-3 pb-10">
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <div class="flex flex-col md:flex-row items-center md:items-start">
                <div class="w-full md:w-1/3 flex justify-center">
                    <img src="{{ $recipe->media->first() !== null ? $recipe->media->first()->getUrl() : asset('images/placeholder.jpg') }}"
                        alt="{{ $recipe->title }} image" class="rounded-2xl shadow-xl w-76 h-76 object-cover" />
                </div>
                <div class="mt-4 md:mt-0 md:ml-6 flex-1">
                    <h1 class="text-4xl font-bold text-[#5B3A1F] mb-4 text-center md:text-left">{{ $recipe->title }}
                    </h1>
                    <div class="text-base">
                        <p class="mb-2 text-black"><strong class="text-[#63462B]">Total Time:</strong>
                            {{ $recipe->formatTime() }}
                        </p>
                        <p class="mb-4 text-black"><strong class="text-[#63462B]">Description:</strong>
                            {{ $recipe->description }}
                        </p>
                    </div>
                    <div class="mt-4 flex justify-center md:justify-start">
                        <x-link mode="primary" href="{{ route('recipes.start', $recipe) }}?step=1">Start Recipe</x-link>
                    </div>
                </div>
            </div>
        </div>
        <section class="mt-5">
            <h2 class="text-3xl font-semibold text-[#412913] mb-6">Steps</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($recipe->steps as $step)
                    <div class="p-6 bg-[#FFF9F3] border border-[#E5DACB] rounded-2xl shadow-xl">
                        <h3 class="text-xl font-bold text-[#5B3A1F] mb-3">{{ $step->title }}</h3>
                        <p class="text-[#63462B]">{{ $step->description }}</p>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="mt-5">
            <h2 class="text-3xl font-semibold text-[#412913] mb-6">Ingredients</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($recipe->getIngredients() as $ingredient)
                    <div
                        class="flex flex-col items-center bg-[#FFF9F3] p-4 rounded-2xl border border-[#E5DACB] shadow-xl">
                        <img src="{{ $ingredient->media->first() !== null ? $ingredient->media->first()->getUrl() : asset('images/placeholder.jpg') }}"
                            alt="{{ $ingredient->name }} image" class="rounded-full w-24 h-24 mb-4 object-cover" />
                        <strong class="text-center text-[#5B3A1F] text-lg font-bold">{{ $ingredient->name }}</strong>
                        <small class="text-center text-[#63462B]">{{ $ingredient->pivot->amount }}
                            {{ $ingredient->pivot->unit }}</small>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-site-layout>
