@props([
    'sortFieldValue', // The field associated with this column to sort by
    'sortField',      // Current sort field
    'sortAsc'         // Boolean indicating sort direction
])

<th scope="col" class="{{ $attributes->get('class') }}">
    <button wire:click="sortBy('{{ $sortFieldValue }}')"
        class="group flex grow-0 items-center space-x-2 text-xs font-medium uppercase tracking-wider {{ $sortField === $sortFieldValue ? 'text-gray-900 underline dark:text-gray-300' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-900 dark:hover:text-gray-300">

        <!-- Column Name -->
        <span>{{ $slot }}</span>

        <!-- Sorting Icon -->
        @if($sortField === $sortFieldValue)
            @if($sortAsc)
                <!-- Sort Descending Icon if sorted ascending currently -->
                <x-svg.sort-desc class="h-3 w-3 grow-0"/>
            @else
                <!-- Sort Ascending Icon if sorted descending currently -->
                <x-svg.sort-asc class="h-3 w-3 grow-0"/>
            @endif
        @else
            <!-- Neutral Sort Icon (inactive) -->
            <x-svg.sort class="opacity-60 group-hover:opacity-100 h-3 w-3 grow-0"/>
        @endif
    </button>
</th>
