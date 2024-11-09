@props([
    'compact' => false,     // Determines spacing between checkboxes if displayed vertically
    'label' => '',          // Label for the entire set of checkboxes
    'inline' => false,      // If true, displays checkboxes in a horizontal (inline) layout
    'optional' => false,    // Indicates if the checkbox set is optional
    'align' => 'justify-start' // Alignment class for inline checkboxes (e.g., left, center, right)
])

<div class="{{ $attributes->get('class') }}" {{ $attributes->whereStartsWith('x') }}>
    <!-- Display the label and optional indicator if a label is provided -->
    @if($label)
        <div class="flex justify-between">
            <label for="{{ $attributes->whereStartsWith('wire:model')->first() }}">
                {!! $label !!}
            </label>
            @if($optional)
                <span class="text-xs text-gray-500" id="email-optional">Optional</span>
            @endif
        </div>
    @endif

    <!-- Checkbox fieldset with conditional styling for inline or stacked layout -->
    <fieldset class="
        mt-2
        @if($inline)
            {{ $align }} flex gap-6 flex-wrap
        @else
            {{ $align }} {{ $compact ? 'space-y-2' : 'space-y-5' }}
        @endif
    ">
        <!-- Slot for rendering individual checkboxes -->
        {{ $slot }}
    </fieldset>
</div>
