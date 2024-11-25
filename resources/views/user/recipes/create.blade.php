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

            <div class="w-full flex justify-end gap-x-4">
                <x-link mode="secondary" href="{{ route('user.recipes.index') }}">Back</x-link>
                <x-button mode="primary" type="submit">Create</x-button>
            </div>
        </form>
    </div>
</x-site-layout>