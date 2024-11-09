@props([
    'route' => '',       // URL route for the breadcrumb link
    'current' => false   // Indicates if this is the current page
])

<li class="flex">
    <div class="flex items-center">
        <!-- Chevron icon separating breadcrumb items -->
        <svg class="grow-0 h-5 w-5 text-gray-400 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>

        <!-- Conditionally render either a link or a span depending on if it's the current page -->
        @if($current)
            <!-- Display text for the current breadcrumb item without a link -->
            <span class="ml-4 text-sm font-medium text-gray-900 flex space-x-2 items-center dark:text-gray-300">
                {{ $slot }}
            </span>
        @else
            <!-- Display a clickable link for non-current breadcrumb items -->
            <a
                @if($attributes->get('tooltip'))
                    tooltip="{{ $attributes->get('tooltip') }}"
                tooltip-p="bottom"
                @endif
                href="{{ $route }}"
                class="ml-4 text-sm font-medium text-gray-500 hover:text-secondary-500 flex space-x-2 items-center">
                {{ $slot }}
            </a>
        @endif
    </div>
</li>
