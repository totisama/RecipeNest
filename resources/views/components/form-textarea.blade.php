<div class="flex flex-col gap-1">
    <label class="block text-xs font-semibold uppercase" for="{{ $name }}">{{ $label }}</label>
    <textarea class="p-1 rounded-lg border border-gray-300 @error($name) border-red-500 @enderror" id="{{ $name }}"
        name="{{ $name }}">{{ old($name, $value) }}</textarea>
    @error($name)
        <span class="text-red-600">{{ $message }}</span>
    @enderror
</div>
