<x-site-layout>
    <x-back-button :route="route('recipes.show', $recipe)" />
    <div class="w-full flex flex-col items-center gap-8">
        <div class="text-center gap-3 flex flex-col items-center">
            <img src="{{ $recipe->image }}" alt="{{ $recipe->title }}" class="w-2/3 max-w-md rounded-xl mt-4" />
            <h1 class="text-4xl font-bold text-[#5B3A1F]">{{ $recipe->title }}</h1>
        </div>
        <div class="w-full max-w-3xl bg-white border border-gray-300 px-6 pt-3 pb-6 rounded-xl shadow-lg">
            <div class="flex justify-end">
                <x-button id="action-button" mode="secondary">
                    Listen
                </x-button>
            </div>
            <h2 class="text-2xl font-semibold text-[#5B3A1F]">Step {{ $step->order }}: {{ $step->title }}</h2>
            <p class="mt-4 text-lg text-gray-700">{{ $step->description }}</p>
            <h3 class="mt-8 text-xl font-semibold text-[#5B3A1F]">Ingredients Needed</h3>
            <ul class="mt-4 list-disc list-inside space-y-2">
                @foreach ($step->ingredients as $ingredient)
                    <li class="text-lg text-gray-700">
                        <strong>{{ $ingredient->pivot->amount }}</strong>
                        <span>{{ $ingredient->pivot->unit }}</span> of
                        <strong>{{ $ingredient->name }}</strong>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full max-w-3xl flex justify-between mt-8">
            @if ($previousStepNumber)
                <x-link mode="primary" href="{{route('recipes.start', $recipe)}}?step={{$previousStepNumber}}">
                    Previous Step
                </x-link>
            @else
                <div></div>
            @endif
            @if ($nextStepNumber)
                <x-link mode="primary" href="{{route('recipes.start', $recipe)}}?step={{$nextStepNumber}}">
                    Next Step
                </x-link>
            @else
                <div></div>
            @endif
        </div>
    </div>
</x-site-layout>