@props(['disabled' => false])

<input @disabled($disabled)
  {{ $attributes->merge(['class' => 'p-2 border-[#D4C4B1] bg-[#F6E9DC] text-[#5B3A1F] rounded-lg shadow-sm placeholder-gray-500 focus:ring-2 focus:ring-[#5B3A1F] focus:border-[#5B3A1F]']) }}>