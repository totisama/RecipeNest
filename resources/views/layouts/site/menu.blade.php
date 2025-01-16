<header class="bg-gray-200 py-2 border-black border-b-[2px]">
    <nav>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Left -->
                <div class="flex text-lg text-black items-center">
                    <div class="shrink-0">
                        <a href="{{ route('welcome') }}" class="flex gap-4 items-center">
                            <img src="{{ asset('images/recipeNest-logo.webp') }}" alt="Recipe Nest Logo"
                                class="w-12 h-12" />
                            {{ config('app.name') }}
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('welcome') }}"
                                class="rounded-xl px-2 py-1 transition-all duration-300 ease-out hover:scale-105 hover:bg-gray-300">
                                Recipes
                            </a>
                            @if (auth()->user() !== null)
                                <a href="{{ route('user.ingredients.index') }}"
                                    class="rounded-xl px-2 py-1 transition-all duration-300 ease-out hover:scale-105 hover:bg-gray-300">
                                    Ingredients
                                </a>
                                <a href="{{ route('user.recipes.index') }}"
                                    class="rounded-xl px-2 py-1 transition-all duration-300 ease-out hover:scale-105 hover:bg-gray-300">
                                    My recipes
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right -->
                @if (Auth::user())
                    <div class="flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black bg100 focus:outline-none transition-all ease-in-out duration-300 hover:shadow-lg">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('welcome')" class="md:hidden">
                                    {{ __('Home') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('user.recipes.index')" class="md:hidden">
                                    {{ __('My recipes') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-xl px-2 py-1 transition-all duration-300 ease-out hover:scale-105 hover:bg-gray-300">
                        Log in
                    </a>
                @endif
            </div>
        </div>
    </nav>
</header>
