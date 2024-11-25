<x-site-layout>
    <div class="w-full flex flex-col items-center gap-5">
        <h1 class="text-4xl font-bold text-center text-[#5B3A1F]">
            New recipe
        </h1>
        <form action="{{route('user.recipes.store')}}" method="post"
            class="w-2/3 bg-white space-y-5 rounded-xl border border-gray-300 p-4">
            @csrf

            <div class="flex gap-5">
                <x-form-text name="title" label="Title" />
                <x-form-number name="total_time" label="Approximate total time (minutes)" />
            </div>
            <x-form-textarea name="description" label="Description" />

            <div class="px-5">
                <div class="flex gap-3">
                    <h2 class="text-2xl font-semibold">Steps</h2>
                    <x-button mode="secondary" id="add-step">+</x-button>
                </div>

                <div class="space-y-5 pb-5 px-5 max-h-[500px] overflow-y-scroll" id="steps-container">
                    <!-- <div>
                        <strong>
                            Step 1
                        </strong>
                        <div class="flex flex-col gap-2">
                            <x-form-text name="step1-title" label="Title" />
                            <x-form-textarea name="step1-description" label="Description" />
                        </div>
                        <div class="mt-2">
                            <div class="flex gap-3">
                                <h2 class="text-xl font-semibold">Ingredients</h2>
                                <x-button mode="secondary" id="step1-add-ingredient">+</x-button>
                            </div>
                            <div id="step1-ingredients-container" class="w-full flex gap-3">
                                <x-form-select name="step1-ingredient1" label="Ingredients" :options="$ingredients" />
                                <x-form-number name="step1-ingredient1-amount" label="Amount" />
                                <x-form-select name="step1-ingredient1-unit" label="Unit" :options="$units" />
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="w-full mt-5 flex justify-end gap-x-4">
                    <x-link mode="secondary" href="{{ route('user.recipes.index') }}">Back</x-link>
                    <x-button mode="primary" type="submit">Create</x-button>
                </div>
            </div>
        </form>
    </div>
</x-site-layout>

<script>
    const ingredients = @json($ingredients);
    const units = @json($units);

    const scrollToBottom = (element) => {
        element.scrollTo({
            top: element.scrollHeight,
            behavior: 'smooth',
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        const stepsContainer = document.getElementById('steps-container');
        const addStepButton = document.getElementById('add-step');
        let stepsAmount = 0;

        const addIngredient = (stepNumber) => {
            const ingredientsContainer = document.getElementById(`step${stepNumber}-ingredients-container`);
            const ingredientCount = ingredientsContainer.children.length + 1;

            const newIngredientDiv = document.createElement('div');
            newIngredientDiv.className = 'w-full flex gap-3';
            newIngredientDiv.innerHTML = `
                <div class="w-full flex gap-3">
                    <x-form-select name="step${stepNumber}-ingredient${ingredientCount}" label="Ingredient ${ingredientCount}" :options="$ingredients" />
                    <x-form-number name="step${stepNumber}-ingredient${ingredientCount}-amount" label="Amount" />
                    <x-form-select name="step${stepNumber}-ingredient${ingredientCount}-unit" label="Unit" :options="$units" />
                </div>
            `;

            ingredientsContainer.appendChild(newIngredientDiv);
        };

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
                            <x-button mode="secondary" id="step${stepsAmount}-add-ingredient">+</x-button>
                        </div>
                        <div id="step${stepsAmount}-ingredients-container" class="w-full flex flex-col gap-3">
                            <div class="w-full flex gap-3">
                                <x-form-select name="step${stepsAmount}-ingredient1" label="Ingredient 1" :options="$ingredients" />
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
                addIngredient(stepsAmount);

                scrollToBottom(stepsContainer)
            });
        };

        addStepButton.addEventListener('click', (e) => {
            e.preventDefault();
            addStep();

            scrollToBottom(stepsContainer)
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