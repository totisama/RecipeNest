@php
    $baseClasses = 'inline-block px-3 py-1 text-base font-medium rounded-lg shadow-md transition-all ease-out duration-300
    hover:scale-105';
    $primaryClasses = 'bg-[#5B3A1F] text-white hover:bg-[#412913] hover:shadow-lg';
    $secondaryClasses = 'bg-white border-[1px] border-gray-400 text-[#5B3A1F] hover:bg-gray-100 hover:shadow-lg';
    $deleteClasses = 'bg-red-500 text-white hover:bg-red-600 hover:shadow-lg';

    $classes = match ($mode) {
        'secondary' => "$baseClasses $secondaryClasses",
        'delete' => "$baseClasses $deleteClasses",
        'primary' => "$baseClasses $primaryClasses"
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>