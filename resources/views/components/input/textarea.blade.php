@props([
    'label' => "",                   // Label text for the textarea
    'required' => false,             // Indicates if the textarea is required
    'placeholder' => "",             // Placeholder text for the textarea
    'subtext' => '',                 // Subtext displayed below the textarea
    'optional' => false,             // Indicates if the field is optional
    'rows' => 3,                     // Number of rows in the textarea
    'fullHeight' => false,           // Boolean to set the textarea to full height
    'disableErrors' => false         // Boolean to disable error styling/messages
])

<div class="{{ $attributes->get('class') }}">
    <!-- Label and Optional Indicator -->
    <div class="flex justify-between">
        <label for="{{ $attributes->whereStartsWith('wire:model')->first() }}" class="{{ $required ? 'required' : '' }}">
            {!! $label !!}
        </label>
        @if($optional)
            <span class="text-xs text-gray-500" id="email-optional">Optional</span>
        @endif
    </div>

    <!-- Textarea Container -->
    <div class="form-input-container @if($fullHeight) h-full @endif">
		<textarea
            rows="{{ $rows }}"
        {{ $attributes->whereStartsWith('wire:model') }}
        placeholder="{{ $placeholder }}"
        id="{{ $attributes->whereStartsWith('wire:model')->first() }}"
        @if($required) required @endif

        @if($disableErrors)
            class="form-input-container__input @if($fullHeight) h-full @endif"
        @else
            @error($attributes->whereStartsWith('wire:model')->first())
            class="form-input-container__input form-input-container__input--has-error @if($fullHeight) h-full @endif"
            aria-invalid="true"
            aria-describedby="{{ $attributes->whereStartsWith('wire:model')->first() }}-error"
            @else
                class="form-input-container__input @if($fullHeight) h-full @endif"
            @endif
        @endif
        ></textarea>

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

    <!-- Subtext Below the Textarea -->
    @if($subtext)
        <p class="mt-2 text-sm text-gray-500" id="email-description">{{ $subtext }}</p>
    @endif

    <!-- Error Message -->
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
