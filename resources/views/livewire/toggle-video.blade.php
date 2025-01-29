<div class="mt-5">
    <button wire:click="toggleVideo"
        class="px-4 py-2 bg-[#63462B] text-white rounded-lg shadow-md hover:bg-[#412913] transition">
        {{ $showVideo ? 'Hide Video' : 'Show Video' }}
    </button>

    @if ($showVideo)
        <div class="mt-4 w-1/2 aspect-video">
            <video controls class="w-full rounded-xl shadow-md">
                <source src="{{ $videoUrl }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif
</div>
