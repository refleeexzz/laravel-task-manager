@props(['size' => 'default'])

@php
    $sizes = [
        'small' => 'w-6 h-6',
        'default' => 'w-8 h-8',
        'large' => 'w-12 h-12',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['default'];
@endphp

<svg {{ $attributes->merge(['class' => $sizeClass . ' flex-shrink-0']) }} viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <!-- Background Square with rounded corners -->
    <rect width="200" height="200" rx="40" class="fill-gray-900 dark:fill-white"/>
    
    <!-- Checkmark -->
    <path d="M60 100 L85 125 L140 70" 
          stroke="white" 
          stroke-width="16" 
          stroke-linecap="round" 
          stroke-linejoin="round"
          class="dark:stroke-gray-900"/>
    
    <!-- Box outline -->
    <rect x="40" y="50" width="120" height="120" rx="12" 
          stroke="white" 
          stroke-width="12" 
          fill="none"
          class="dark:stroke-gray-900"/>
</svg>
