@props([
    'label' => "",            // Label for the date input
    'required' => false,      // Specifies if the field is required
    'placeholder' => "",      // Placeholder text for the input
    'lead' => "",             // Leading icon or text
    'subtext' => '',          // Additional helper text below the input
    'optional' => false,      // If true, displays an "Optional" indicator
    'maxDate' => null,        // Maximum selectable date
    'minDate' => null,        // Minimum selectable date
    'disableErrors' => false, // If true, disables error display for this input
])

<div class="{{ $attributes->get('class') }}">
    <!-- Label and Optional Text -->
    <div class="flex justify-between">
        <label for="{{ $attributes->whereStartsWith('wire:model')->first() }}"
            class="{{ $required ? 'required' : '' }}">{!! $label !!}</label>
        @if($optional)
            <span class="text-xs text-gray-500" id="email-optional">Optional</span>
        @endif
    </div>

    <!-- Date Picker Input Container -->
    <div class="form-input-container"
        wire:ignore
        x-data=""
        x-init="
            flatpickr($refs.input, {
                dateFormat:'Y-m-d',
                altFormat:'F j, Y',
                altInput:true,
                @if($maxDate)
                maxDate: '{{ $maxDate }}',
                @endif
                @if($minDate)
                minDate: '{{ $minDate }}',
                @endif
            });
            this.addEventListener('datePickerReset', e => {
                flatpickr($refs.input, {
                    dateFormat:'Y-m-d',
                    altFormat:'F j, Y',
                    altInput:true,
                    @if($maxDate)
                    maxDate: '{{ $maxDate }}',
                    @endif
                    @if($minDate)
                    minDate: '{{ $minDate }}',
                    @endif
                });
            });
        "
    >
        <!-- Calendar Icon -->
        <span class="form-input-container__lead">
            <x-svg.calendar class="h-5 w-5"/>
        </span>

        <!-- Date Input Field -->
        <input
            type="text"
            {{ $attributes->whereStartsWith('wire:model') }}
            placeholder="{{ $placeholder }}"
            id="{{ $attributes->whereStartsWith('wire:model')->first() }}"
            data-input
            @if($required) required @endif
        onkeydown="return event.key !== 'Enter';"
            @if($disableErrors)
                class="form-input-container__input form-input-container__input--has-lead"
            @else
                @error($attributes->whereStartsWith('wire:model')->first())
                class="form-input-container__input form-input-container__input--has-error form-input-container__input--has-lead"
            aria-invalid="true"
            aria-describedby="{{ $attributes->whereStartsWith('wire:model')->first() }}-error"
            @else
                class="form-input-container__input form-input-container__input--has-lead"
            @endif
            @endif
            x-ref="input"
        >

        <!-- Error Icon if Validation Fails -->
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

    <!-- Optional Subtext -->
    @if($subtext)
        <p class="mt-2 text-sm text-gray-500" id="email-description">{{ $subtext }}</p>
    @endif

    <!-- Error Message if Validation Fails -->
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

@assets
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endassets
