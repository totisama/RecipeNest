<x-site-layout>
    <div class="w-full flex flex-col items-center gap-5">
        <h1 class="text-4xl font-bold text-center text-[#5B3A1F]">
            New ingredient
        </h1>
        <form action="{{route('user.ingredients.store')}}" method="post"
            class="w-2/3 bg-white border border-gray-300 p-4">
            @csrf

            <x-form-text name="name" label="Name" />
            <x-form-textarea name="content" label="Content" />

            <div class="w-full flex justify-end gap-x-4">
                <x-link mode="secondary" href="{{ route('user.ingredients.index') }}">Back</x-link>
                <x-button mode="primary" type="submit">Create</x-button>
            </div>
        </form>
    </div>
</x-site-layout>