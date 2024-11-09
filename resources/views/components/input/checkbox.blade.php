@props([
    'label' => '',          // Label for the checkbox
    'description' => null,  // Additional descriptive text for the checkbox
    'value' => '',          // Value of the checkbox input
    'type' => 'checkbox',   // Type of input, defaulting to "checkbox"
    'uid' => rand(),        // Unique identifier to differentiate checkboxes, using a random number
    'id' => '',             // Optional ID for the checkbox input
])

<div class="relative flex items-start">
    <div class="flex items-center h-5">
        <!-- Checkbox Input -->
        <input
            wire:key="checkbox_{{ $attributes->whereStartsWith('wire:model')->first() }}_{{ $uid }}"
            {{ $attributes->whereStartsWith('wire:model') }}
            {{ $attributes->whereStartsWith('x') }}
            value="{{ $value }}"
            @if($id)
                id="{{ $id }}"
            @else
                id="checkbox-{{ $attributes->whereStartsWith('wire:model')->first() }}-{{ $uid }}"
            @endif
            aria-describedby="checkbox-{{ $attributes->whereStartsWith('wire:model')->first() }}-description_{{ $uid }}"
            type="{{ $type }}"
            class="focus:ring-secondary-500 h-5 w-5 text-secondary-600 border border-gray-300 rounded">
    </div>

    <!-- Label and Description -->
    <div class="ml-3 text-sm">
        <!-- Checkbox Label -->
        <label
            @if($id)
                for="{{ $id }}"
            @else
                for="checkbox-{{ $attributes->whereStartsWith('wire:model')->first() }}-{{ $uid }}"
            @endif
            class="font-medium text-gray-700">{{ $label }}</label>

        <!-- Optional Description -->
        @if($description)
            <p id="checkbox-{{ $attributes->whereStartsWith('wire:model')->first() }}-description_{{ $uid }}"
                class="text-gray-500">{{ $description }}</p>
        @endif
    </div>
</div>
