<div class="p-4 my-4">
    <div class="flex flex-col items-end">
        <button wire:click="createToken"
            class="inline-block bg-[#5B3A1F] w-fit text-white px-3 py-1 text-base font-medium rounded-lg shadow-md transition-all ease-out duration-300 hover:bg-[#412913] hover:shadow-lg hover:scale-105 ">
            Create new token
        </button>
        <small class="text-white text-sm">Your previous tokens will be deleted</small>
    </div>

    <h2 class="font-bold text-2xl">API tokens</h2>
    @if ($token)
        <span>You can use <strong>{{ $token }}</strong></span>
    @endif
</div>