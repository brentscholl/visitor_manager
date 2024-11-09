@props([
    'type' => "text",            // Input type, default is 'text'
    'label' => "",               // Label for the input field
    'required' => false,         // Indicates if the input is required
    'placeholder' => "",         // Placeholder text for the input
    'lead' => "",                // Optional leading icon or text
    'tail' => "",                // Optional trailing icon or text
    'subtext' => '',             // Subtext displayed under the input field
    'optional' => false,         // Displays an 'Optional' tag if true
    'disabled' => false,         // Disables the input if true
    'disableErrors' => false     // Disables error display if set to true
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

    <!-- Input Field Container with Optional Lead and Tail Elements -->
    <div class="form-input-container">
        @if($lead)
            <span class="form-input-container__lead">
              {{ $lead }}
            </span>
        @endif

        <input
            @if($disabled) disabled @endif
        {{ $attributes->whereStartsWith('min') }}
        {{ $attributes->whereStartsWith('max') }}
        {{ $attributes->whereStartsWith('maxlength') }}
        {{ $attributes->whereStartsWith('wire:model') }}
        type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            id="{{ $attributes->whereStartsWith('wire:model')->first() }}"
            @if($required) required @endif
        onkeydown="return event.key !== 'Enter';"

            @if($disableErrors)
                class="form-input-container__input @if($lead) form-input-container__input--has-lead @endif @if($tail) form-input-container__input--has-tail @endif"
            @else
                @error($attributes->whereStartsWith('wire:model')->first())
                class="form-input-container__input form-input-container__input--has-error @if($lead) form-input-container__input--has-lead @endif @if($tail) form-input-container__input--has-tail @endif"
            aria-invalid="true"
            aria-describedby="{{ $attributes->whereStartsWith('wire:model')->first() }}-error"
            @else
                class="form-input-container__input @if($lead) form-input-container__input--has-lead @endif @if($tail) form-input-container__input--has-tail @endif"
            @endif
            @endif
        >

        @if($tail)
            <span class="form-input-container__tail">
		  		{{ $tail }}
			</span>
        @endif

        <!-- Error Icon Display -->
        @if(!$disableErrors)
            @error($attributes->whereStartsWith('wire:model')->first())
            <div wire:key="error_svg_{{ $attributes->whereStartsWith('wire:model')->first() }}"
                class="form-input-container__input__icon--has-error"
            >
                <x-svg.error/>
            </div>
            @enderror
        @endif
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
