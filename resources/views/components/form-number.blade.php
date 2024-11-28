<div class="w-full flex flex-col gap-1">
  <label class="block text-xs font-semibold uppercase" for="{{ $name }}">{{ $label }}</label>
  <input type="number" min="{{ $min ?? '1'}}" step="0.1"
    class=" p-1 rounded-lg border border-gray-300 @error($name) border-red-500 @enderror" type="text" id="{{ $name }}"
    name="{{ $name }}" value="{{ old($name, $value) }}" />
  @error($name) <span class="text-red-600">{{ $message }}</span>
  @enderror
</div>
