@props([
    'label' => "",             // Label for the select input
    'required' => false,       // Indicates if the select input is required
    'lead' => "",              // Optional leading icon or text within the input
    'subtext' => '',           // Subtext displayed under the select input
    'optional' => false,       // Displays an 'Optional' tag if true
    'disableErrors' => false,  // Disables error styling if set to true
])

<div class="{{ $attributes->get('class') }}">
    <!-- Label and Optional Tag -->
    <div class="flex justify-between">
        <label
            for="{{ $attributes->whereStartsWith('wire:model')->first() }}"
            class="{{ $required ? 'required' : '' }}"
        >
            {!! $label !!}
        </label>
        @if($optional)
            <span class="text-xs text-gray-500" id="email-optional">Optional</span>
        @endif
    </div>

    <!-- Select Input Container with Optional Lead Icon/Text -->
    <div class="form-input-container">
        @if($lead)
            <span class="form-input-container__lead">
                {{ $lead }}
            </span>
        @endif
        <select
            onkeydown="return event.key !== 'Enter';"
        {{ $attributes->whereStartsWith('wire:model') }}
        id="{{ $attributes->whereStartsWith('wire:model')->first() }}"
        @if($required) required @endif

        @if($disableErrors)
            class="form-input-container__input @if($lead) form-input-container__input--has-lead @endif"
        @else
            @error($attributes->whereStartsWith('wire:model')->first())
            class="form-input-container__input form-input-container__input--has-error @if($lead) form-input-container__input--has-lead @endif"
            aria-invalid="true"
            aria-describedby="{{ $attributes->whereStartsWith('wire:model')->first() }}-error"
            @else
                class="form-input-container__input @if($lead) form-input-container__input--has-lead @endif"
            @endif
        @endif
        >
        {{ $slot }} <!-- Slot for select options -->
        </select>
    </div>

    <!-- Subtext for Additional Information -->
    @if($subtext)
        <p class="mt-1 text-xs text-gray-500">{!! $subtext !!}</p>
    @endif

    <!-- Error Message Display -->
    @if(!$disableErrors)
        @error($attributes->whereStartsWith('wire:model')->first())
        <p wire:key="error_{{ $attributes->whereStartsWith('wire:model')->first() }}"
            class="form-input-container__input__error-message"
            id="error-{{ $attributes->whereStartsWith('wire:model')->first() }}"
        >
            {{ $message }}
        </p>
        @enderror
    @endif
</div>
