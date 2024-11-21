<header class="bg-gray-200 py-2 border-black border-b-[2px]">
    <nav>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex text-lg text-black items-center">
                    <div class="shrink-0">
                        <a href="{{route('welcome')}}" class="flex gap-4 items-center">
                            <img src="{{asset('images/recipeNest-logo.webp')}}" alt="Recipe Nest Logo"
                                class="w-12 h-12" />
                            Recipe Nest
                        </a>
                    </div>
                    <div>
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{route('welcome')}}"
                                class="rounded-xl px-2 py-1 transition-all duration-300 ease-out hover:scale-105 hover:bg-gray-300">
                                Home
                            </a>
                            <a href="{{route('user.recipes.index')}}"
                                class="rounded-xl px-2 py-1 transition-all duration-300 ease-out hover:scale-105 hover:bg-gray-300">
                                My recipes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>