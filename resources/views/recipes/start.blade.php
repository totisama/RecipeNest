<x-site-layout>
    <x-back-button :route="route('recipes.show', $recipe)" />
    <div class="w-full max-w-4xl mx-auto mt-4 p-6 bg-gray-100 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-full md:w-1/3">
                <img src="{{ $recipe->media->first()->getUrl() }}" alt="{{ $recipe->title }}"
                    class="w-full rounded-lg shadow" />
            </div>
            <div class="flex flex-col w-full md:w-2/3">
                <h1 class="text-4xl font-bold text-[#5B3A1F]">{{ $recipe->title }}</h1>
                <p class="mt-2 text-lg text-gray-600">Step {{ $step->order }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-[#5B3A1F]">{{ $step->title }}</h2>
                <p class="mt-2 text-gray-700 text-base">{{ $step->description }}</p>
            </div>
        </div>
        <div class="mt-4">
            <x-button id="listen-button" mode="secondary">
                Listen
            </x-button>
        </div>
        <div class="mt-4">
            <h3 class="text-xl font-bold text-[#5B3A1F] mb-4">Ingredients</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($step->ingredients as $ingredient)
                    <div class="flex items-center gap-4 p-4 bg-white rounded-lg shadow">
                        <img src="{{ $ingredient->image }}" alt="{{ $ingredient->name }}"
                            class="w-16 h-16 rounded-lg object-cover" />
                        <div>
                            <p class="text-lg font-semibold text-gray-700">{{ $ingredient->name }}</p>
                            <p class="text-sm text-gray-600">
                                <strong>{{ $ingredient->pivot->amount }}</strong> {{ $ingredient->pivot->unit }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-between items-center mt-8">
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
            @endif
        </div>
    </div>
</x-site-layout>

<script>
    const step = @json($step);
    const textToSpeak = step.title + '.. ' + step.description;
    const utterance = new SpeechSynthesisUtterance(textToSpeak);
    let playing = false;

    utterance.lang = 'en-US';
    utterance.rate = 0.5;

    const finishInstructions = function () {
        playing = false;
    };

    document.getElementById('listen-button').addEventListener('click', function () {
        if (playing) {
            return;
        }

        speechSynthesis.speak(utterance);
        utterance.onend = finishInstructions;
        playing = true;
    });
</script>