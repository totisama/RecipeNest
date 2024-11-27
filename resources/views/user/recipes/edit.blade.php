<?php
$comingStepsAmount = session()->has('stepsAmount') ? session('stepsAmount') : $stepsObject
?>


<x-site-layout>
    <div class="w-full flex flex-col items-center gap-5">
        <h1 class="text-4xl font-bold text-center text-[#5B3A1F]">
            Edit <strong class="italic">{{$recipe->title}}</strong> recipe
        </h1>
        <form action="{{route('user.recipes.update', $recipe)}}" method="post" enctype="multipart/form-data"
            class="w-full bg-white space-y-5 rounded-xl border border-gray-300 p-4 md:w-2/3">
            @method('PUT')
            @csrf

            <div class="flex flex-col gap-5 md:flex-row">
                <x-form-text value="{{$recipe->title}}" name="title" label="Title" />
                <x-form-number value="{{$recipe->total_time}}" name="total_time"
                    label="Approximate total time (minutes)" />
            </div>
            <x-form-image name="image" value="{{$recipe->media->first()->getUrl()}}" />
            <x-form-textarea value="{{$recipe->description}}" name="description" label="Description" />

            <div class="px-5">
                <div class="flex gap-3 mb-5">
                    <h2 class="text-2xl font-semibold">Steps</h2>
                    <x-button mode="secondary" id="add-step">+</x-button>
                </div>

                <div class="space-y-5 pb-5 px-5 max-h-[500px] overflow-y-scroll" id="steps-container">
                    @if(gettype($comingStepsAmount) === 'array' && count($comingStepsAmount) > 0)
                        @foreach ($comingStepsAmount as $stepIndex => $step)
                            <div>
                                <strong>
                                    Step {{$stepIndex}}
                                </strong>
                                <div class="flex flex-col gap-2">
                                    <input class="hidden" value="{{$step['id'] ?? null}}" name="step{{$stepIndex}}-id" />
                                    <x-form-text value="{{$step['title']}}" name="step{{$stepIndex}}-title" label="Title" />
                                    <x-form-textarea value="{{$step['description']}}" name="step{{$stepIndex}}-description"
                                        label="Description" />
                                </div>
                                <div class="mt-2">
                                    <div class="flex gap-3">
                                        <h2 class="text-xl font-semibold">Ingredients</h2>
                                        <x-button mode="secondary" data-step="{{$stepIndex}}"
                                            id="step{{$stepIndex}}-add-ingredient">+
                                        </x-button>
                                    </div>
                                    <div id="step{{$stepIndex}}-ingredients-container" class="w-full flex flex-col gap-3">
                                        @foreach ($step['ingredients'] as $ingredientIndex => $ingredient)
                                            <div class="w-full gap-3 flex flex-col md:flex-row">
                                                <x-form-select name="step{{$stepIndex}}-ingredient{{$ingredientIndex}}-id"
                                                    label="Ingredient {{$ingredientIndex}}" :options="$ingredients"
                                                    value="{{$ingredient['id']}}" />
                                                <x-form-number name="step{{$stepIndex}}-ingredient{{$ingredientIndex}}-amount"
                                                    label="Amount" value="{{$ingredient['amount']}}" />
                                                <x-form-select name="step{{$stepIndex}}-ingredient{{$ingredientIndex}}-unit"
                                                    label="Unit" :options="$units" value="{{$ingredient['unit']}}" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="w-full mt-5 flex justify-end gap-x-4">
                    <x-link mode="secondary" href="{{ route('user.recipes.index') }}">Back</x-link>
                    <x-button mode="primary" type="submit">Update</x-button>
                </div>
            </div>
        </form>
    </div>
</x-site-layout>

<script>
    const ingredients = @json($ingredients);
    const units = @json($units);
    const comingStepsAmount = @json($comingStepsAmount);

    const scrollToBottom = (element) => {
        element.scrollTo({
            top: element.scrollHeight,
            behavior: 'smooth',
        });
    };

    const scrollToElement = (element) => {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center',
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        const stepsContainer = document.getElementById('steps-container');
        const addStepButton = document.getElementById('add-step');
        let stepsAmount = 0;

        const addEventToExistingAddIngredientButtons = (stepsAmount) => {
            // if there is only one step, his add ingredient button has already an event listener
            if (stepsAmount <= 1) {
                return;
            }

            for (let i = 2; i <= stepsAmount; i++) {
                const addIngredientButton = document.getElementById(`step${i}-add-ingredient`);
                addIngredientButton.addEventListener('click', (e) => {
                    e.preventDefault();

                    addIngredient(i);
                });
            }
        }

        const addIngredient = (stepNumber) => {
            const ingredientsContainer = document.getElementById(`step${stepNumber}-ingredients-container`);
            const ingredientCount = ingredientsContainer.children.length + 1;

            const newIngredientDiv = document.createElement('div');
            newIngredientDiv.className = 'w-full flex gap-3';
            newIngredientDiv.innerHTML = `
                <div class="w-full gap-3 flex flex-col md:flex-row">
                    <x-form-select name="step${stepNumber}-ingredient${ingredientCount}-id" label="Ingredient ${ingredientCount}" :options="$ingredients" />
                    <x-form-number name="step${stepNumber}-ingredient${ingredientCount}-amount" label="Amount" />
                    <x-form-select name="step${stepNumber}-ingredient${ingredientCount}-unit" label="Unit" :options="$units" />
                </div>
            `;

            ingredientsContainer.appendChild(newIngredientDiv);


            scrollToElement(newIngredientDiv);
        };

        if (typeof comingStepsAmount === 'object') {
            stepsAmount = Object.keys(comingStepsAmount).length

            addEventToExistingAddIngredientButtons(stepsAmount);
        }

        const addStep = () => {
            stepsAmount++;

            const newStepDiv = document.createElement('div');
            newStepDiv.innerHTML = `
                <div>
                    <strong>
                        Step ${stepsAmount}
                    </strong>
                    <div class="flex flex-col gap-2">
                        <x-form-text name="step${stepsAmount}-title" label="Title" />
                        <x-form-textarea name="step${stepsAmount}-description" label="Description" />
                    </div>
                    <div class="mt-2">
                        <div class="flex gap-3">
                            <h2 class="text-xl font-semibold">Ingredients</h2>
                            <x-button mode="secondary" data-step="${stepsAmount}" id="step${stepsAmount}-add-ingredient">+</x-button>
                        </div>
                        <div id="step${stepsAmount}-ingredients-container" class="w-full flex flex-col gap-3">
                            <div class="w-full gap-3 flex flex-col md:flex-row">
                                <x-form-select name="step${stepsAmount}-ingredient1-id" label="Ingredient 1" :options="$ingredients" />
                                <x-form-number name="step${stepsAmount}-ingredient1-amount" label="Amount" />
                                <x-form-select name="step${stepsAmount}-ingredient1-unit" label="Unit" :options="$units" />
                            </div>
                        </div>
                    </div>
                </div>
            `;

            stepsContainer.appendChild(newStepDiv);

            const addIngredientButton = document.getElementById(`step${stepsAmount}-add-ingredient`);
            addIngredientButton.addEventListener('click', (e) => {
                e.preventDefault();

                const step = addIngredientButton.getAttribute('data-step')
                addIngredient(step);
            });

            scrollToBottom(stepsContainer);
        };

        addStepButton.addEventListener('click', (e) => {
            e.preventDefault();
            addStep();
        });

        const initialAddIngredientButton = document.getElementById('step1-add-ingredient');
        if (initialAddIngredientButton) {
            initialAddIngredientButton.addEventListener('click', (e) => {
                e.preventDefault();
                addIngredient(1);
            });
        }
    });
</script>