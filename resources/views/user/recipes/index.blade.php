<?php
$isSuccess = session()->has('success');
?>

<x-site-layout>
    <div class="max-w-6xl mx-auto">
        <h1 class="text-5xl font-bold text-center text-[#5B3A1F] mb-6">
            My Recipes
        </h1>
        <div class="flex mt-5 {{ $isSuccess ? 'justify-between' : 'justify-end' }} mb-2">
            @if ($isSuccess)
                <div
                    class="w-2/5 px-3 py-1 text-base text-center font-medium rounded-lg p-2 bg-green-300 text-green-900">
                    {{ session('success') }}
                </div>
            @endif
            <x-link mode="primary" href="{{ route('user.recipes.create') }}">
                Create recipe
            </x-link>
        </div>
        <div class="space-y-4 bg-white rounded-xl">
            @foreach ($recipes as $recipe)
                <div
                    class="flex items-center flex-col justify-between border-b-black border-b-[1px] p-4 md:flex-row last:border-b-0">
                    <div class="flex flex-col items-center gap-4 md:flex-row">
                        <img src="{{ $recipe->media->first() !== null ? $recipe->media->first()->getUrl() : asset('images/placeholder.jpg') }}"
                            alt="{{ $recipe->title }}" class="w-24 h-24 rounded-lg object-cover" />
                        <a href="{{ route('recipes.show', $recipe->id) }}"
                            class="w-full px-0 md:px-5 transition-all duration-300 ease-out md:w-4/5 hover:scale-105">
                            <h2 class="text-xl text-center md:text-start font-semibold text-[#5B3A1F]">
                                {{ $recipe->title }}
                            </h2>
                        </a>
                    </div>
                    <div class="flex gap-4 mt-5 md:mt-0">
                        <x-link mode="secondary" href="{{ route('user.recipes.edit', $recipe->id) }}">Edit</x-link>
                        <form action="{{ route('user.recipes.destroy', $recipe->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button mode="delete" type="submit">Delete</x-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-site-layout>
