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

            <div class="w-full flex justify-end gap-x-8">
                <button type="submit"
                    class="text-xs text-green-700 bg-green-300 hover:bg-green-200 px-4 py-2 rounded uppercase">Create</button>
                <a class="text-xs text-gray-700 bg-gray-300 hover:bg-gray-200 px-4 py-2 rounded uppercase"
                    href="{{route('user.ingredients.index')}}">Back</a>
            </div>
        </form>
    </div>
</x-site-layout>