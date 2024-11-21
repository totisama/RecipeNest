@php
    $baseClasses = 'inline-block px-6 py-3 text-base font-medium rounded-lg shadow-md transition-all ease-out duration-300
    hover:scale-105';
    $primaryClasses = 'bg-[#5B3A1F] text-white hover:bg-[#412913] hover:shadow-lg';
    $secondaryClasses = 'bg-gray-200 text-[#5B3A1F] hover:bg-gray-300 hover:shadow-lg';

    $classes = $mode === 'primary' ? "$baseClasses $primaryClasses" : "$baseClasses $secondaryClasses";
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{
    $slot }}
</a>