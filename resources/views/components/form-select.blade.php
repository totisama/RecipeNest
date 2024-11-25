<div class="w-full flex flex-col gap-1">
    <label for="{{ $name }}" class="block text-xs font-semibold uppercase">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}"
        class="p-1 rounded-lg border border-gray-300 @error($name) border-red-500 @enderror"">
        <option value="">Select an option</option>
        @foreach ($options as $option)
            <option value="{{ $option }}" {{ $option === $value ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    </select>
    @error($name) <span class="text-red-600">{{ $message }}</span>
    @enderror
</div>