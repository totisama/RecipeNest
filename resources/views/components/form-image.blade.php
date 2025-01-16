<div class="flex flex-col gap-3">
    <img id="preview" src="{{ $value ?? '#' }}" alt="Selected image preview"
        class="{{ $value ? '' : 'hidden' }} w-40 h-40 object-cover rounded-lg border" />
    <input type="file" name="{{ $name }}" accept="image/*" onchange="previewImage(event)" class="mb-3" />
</div>
@error($name)
    <span class="text-red-600">{{ $message }}</span>
@enderror

<script>
    function previewImage(event, name) {
        const input = event.target;
        const preview = document.getElementById(`preview`);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
