<x-site-layout title="Welcome page">
    <div class="grid grid-cols-2 gap-x-8">
        @foreach ($recipes as $recipe)
            <a class='mt-5'>
                <h2 class="font-bold text-lg">{{ $recipe->title }}</h2>
            </a>
        @endforeach
    </div>
</x-site-layout>