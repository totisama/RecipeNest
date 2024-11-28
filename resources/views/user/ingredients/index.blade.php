<?php
$isSuccess = session()->has('success');
$isSuccessOrError = $isSuccess || session()->has('error');
?>

<x-site-layout>
    <h1 class="text-4xl font-bold text-center text-[#5B3A1F]">
        Ingredients
    </h1>
    <div class="flex {{ $isSuccessOrError ? 'justify-between' : 'justify-end' }} mb-2">
        @if ($isSuccessOrError)
            <div class="w-2/5 px-3 py-1 text-base text-center font-medium rounded-lg p-2
                    {{ $isSuccess ? 'bg-green-300 text-green-900' : 'bg-red-300 text-red-900' }}">
                {{ session($isSuccess ? 'success' : 'error') }}
            </div>
        @endif
        <x-link mode="primary" href="{{ route('user.ingredients.create') }}">
            Create ingredient
        </x-link>
    </div>
    <div style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));"
        class="mt-3 mb-10 grid gap-x-8 gap-y-6 place-items-center">
        @foreach ($ingredients as $ingredient)
            <article
                class="h-auto overflow-hidden select-none pb-3 max-w-80 flex flex-col items-center gap-4 bg-white w-full px-5 rounded-3xl">
                <img src="{{$ingredient->media->first()->getUrl()}}" alt="{{$ingredient->name}} image"
                    class="rounded-3xl h-32 transition-transform duration-300 ease-out md:h-40 hover:scale-110" />
                <h2 class="text-[#5B3A1F] text-center font-bold text-base md:text-xl">{{ $ingredient->name }}</h2>
                <form action="{{ route('user.ingredients.destroy', $ingredient->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button mode="delete" type="submit">Delete</x-button>
                </form>
            </article>
        @endforeach
    </div>

</x-site-layout>