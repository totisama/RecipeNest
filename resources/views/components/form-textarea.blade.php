<div class="my-5 flex flex-col">
  <label class="block text-xs font-semibold uppercase" for="content">Content</label>
  <textarea class="p-1 rounded-lg border border-gray-300 @error('content') border-red-500 @enderror"
    name="content">{{old('content')}}</textarea>
  @error('content') <span class="text-red-600">{{$message}}</span> @enderror
</div>
