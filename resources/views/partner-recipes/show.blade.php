<x-site-layout>
    <x-back-button route="{{ route('partner-recipes') }}" />
    <div class="max-w-5xl mx-auto px-6 pt-3 pb-10">
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <div class="flex flex-col md:flex-row items-center md:items-start">
                <div class="w-full md:w-1/3 flex justify-center">
                    <img src="{{ $recipe['image'] ? $recipe['image'] : asset('images/placeholder.jpg') }}"
                        alt="{{ $recipe['title'] }} image" class="rounded-2xl shadow-xl w-76 h-76 object-cover" />
                </div>
                <div class="mt-4 md:mt-0 md:ml-6 flex-1">
                    <h1 class="text-4xl font-bold text-[#5B3A1F] mb-4 text-center md:text-left">{{ $recipe['title'] }}
                    </h1>
                    <div class="text-base">
                        <p class="mb-2 text-black"><strong class="text-[#63462B]">Total Time:</strong>
                            {{ $recipe['total_time'] }}
                        </p>
                        <p class="mb-4 text-black"><strong class="text-[#63462B]">Description:</strong>
                            {{ $recipe['description'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <section class="mt-5">
            <h2 class="text-3xl font-semibold text-[#412913] mb-6">Instructions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($recipe['instructions'] as $instruction)
                    <div class="p-6 bg-[#FFF9F3] border border-[#E5DACB] rounded-2xl shadow-xl">
                        <h3 class="text-xl font-bold text-[#5B3A1F] mb-3">{{ $instruction->position }}</h3>
                        <p class="text-[#63462B]">{{ $instruction->display_text }}</p>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="mt-5">
            <h2 class="text-3xl font-semibold text-[#412913] mb-6">Ingredients</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($recipe['components'] as $component)
                    <div
                        class="flex flex-col justify-around items-center bg-[#FFF9F3] p-4 rounded-2xl border border-[#E5DACB] shadow-xl">
                        <strong
                            class="text-center text-[#5B3A1F] text-xl font-bold">{{ $component->ingredient->name }}</strong>
                        <strong class="text-center text-[#5B3A1F] text-base">{{ $component->raw_text }}</strong>
                        <div class="flex space-x-2">
                            @foreach ($component->measurements as $measurement)
                                @if (!$measurement->quantity || $measurement->quantity == 0)
                                    <small class="text-center text-[#63462B]">
                                        User preference
                                    </small>
                                @else
                                    <small
                                        class="text-center text-[#63462B] after:content-['|'] after:ml-2 last:after:hidden">{{ $measurement->quantity }}
                                        {{ $measurement->unit->name }}</small>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-site-layout>