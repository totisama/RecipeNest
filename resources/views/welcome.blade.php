<x-site-layout>
    <div class="my-10 grid grid-cols-2 gap-x-8 gap-y-6 place-items-center md:grid-cols-3">
        @foreach ($recipes as $recipe)
            <a href="{{route('recipes.show', [$recipe->id])}}"
                class='group h-72 overflow-hidden select-none pb-3 flex flex-col items-center gap-4 bg-white w-full px-5 rounded-3xl transition-transform duration-300 ease-out md:h-full md:max-w-80 hover:cursor-pointer hover:scale-105'>
                <img src="{{$recipe->image}}" alt="{{$recipe->title}} image"
                    class="rounded-3xl h-40 transition-transform duration-300 ease-out md:h-56 group-hover:scale-105" />
                <div class="h-full w-full flex flex-col justify-between">
                    <h2 class="text-[#5B3A1F] text-center font-bold text-base md:text-xl">{{ $recipe->title }}</h2>
                    <div class="px-3 flex flex-col">
                        <small class="text-semibold text-[#B2794B] text-sm md:text-lg">
                            {{count($recipe->steps)}} steps
                        </small>
                        <small class="text-semibold text-[#B2794B] text-sm md:text-lg">
                            Estimated time: {{$recipe->formatTime()}}
                        </small>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-site-layout>