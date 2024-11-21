<x-site-layout>
    <div class="my-10 grid grid-cols-2 gap-x-8 gap-y-6 place-items-center md:grid-cols-3">
        @foreach ($recipes as $recipe)
            <a
                class='group h-full overflow-hidden max-w-80 select-none pb-3 flex flex-col items-center gap-4 bg-white w-full px-5 rounded-3xl transition-transform duration-300 ease-out hover:cursor-pointer hover:scale-105'>
                <img src="{{$recipe->image}}" alt="{{$recipe->title}} image"
                    class="rounded-3xl h-56 transition-transform duration-300 ease-out group-hover:scale-105" />
                <div class="h-full w-full flex flex-col justify-between">
                    <h2 class="text-[#5B3A1F] text-center font-bold text-lg md:text-xl">{{ $recipe->title }}</h2>
                    <div class="px-3 flex flex-col">
                        <small class="text-semibold text-[#B2794B] text-base md:text-lg">Estimated time:
                            {{$recipe->formatTime()}}</small>
                        <small class="text-semibold text-[#B2794B] text-base md:text-lg">Steps:
                            {{count($recipe->steps)}}</small>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-site-layout>