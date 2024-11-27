<div class="flex flex-col">
    <input type="file" name="{{$name}}" />
    @error($name)
        <span class="text-red-600">{{ $message }}</span>
    @enderror
</div>