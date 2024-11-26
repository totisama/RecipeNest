<x-site-layout>
    <x-back-button route="{{route('welcome')}}" />
    <div class="max-w-4xl mt-5 mb-10 mx-auto px-6 md:mt-0">
        <h1 class="text-4xl font-bold text-center text-[#5B3A1F] mb-6">{{ $recipe->title }}</h1>
        <div class="flex justify-center mb-6">
            <img src="{{ $recipe->image }}" alt="{{ $recipe->title }} image" class="rounded-xl w-full max-w-md" />
        </div>
        <div class="mb-5">
            <p class="text-lg text-[#63462B]"><strong>Total Time:</strong> {{ $recipe->formatTime() }}</p>
            <p class="text-lg text-[#63462B]"><strong>Description:</strong> {{ $recipe->description }}</p>
            <div class="mt-3">
                <x-link mode="primary" href="{{route('recipes.start', $recipe)}}?step=1">Start Recipe</x-link>
            </div>
        </div>
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-[#412913] mb-4">Steps</h2>
            <ol class="list-decimal pl-6 text-[#5B3A1F]">
                @foreach ($recipe->steps as $step)
                    <li class="mb-3">
                        <h3 class="font-bold text-lg">{{ $step->title }}</h3>
                        <p class="text-base">{{ $step->description }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
        <div>
            <h2 class="text-2xl font-semibold text-[#412913] mb-4">Ingredients</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($recipe->getIngredients() as $ingredient)
                    <div class="flex flex-col items-center">
                        <img src="{{ $ingredient->image }}" alt="{{ $ingredient->name }} image"
                            class="rounded-full w-20 h-20" />
                        <strong class="text-center text-[#5B3A1F] font-bold">{{ $ingredient->name }}</strong>
                        <small class="text-center text-[#5B3A1F] font-semibold">{{ $ingredient->pivot->amount }}
                            {{ $ingredient->pivot->unit }}
                        </small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-site-layout>