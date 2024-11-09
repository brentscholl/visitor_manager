@props([
    'label' => '',  // Label text for the file input
])

<div x-data="{ photoName: null, photoPreview: null }" class="col-span-2">
    <!-- Profile Photo File Input -->
    <input type="file" class="hidden"
        {{ $attributes->whereStartsWith('wire:model') }}
        x-ref="photo"
        x-on:change="
            // Store the name of the selected photo
            photoName = $refs.photo.files[0].name;
            const reader = new FileReader();
            reader.onload = (e) => {
                // Set photoPreview to the uploaded photo's data URL
                photoPreview = e.target.result;
            };
            // Read the selected file as a Data URL
            reader.readAsDataURL($refs.photo.files[0]);
        "
    />

    <!-- Input Label -->
    <label for="{{ $attributes->whereStartsWith('wire:model')->first() }}">{!! $label !!}</label>

    <!-- Profile Photo Display and Action Buttons -->
    <div class="mt-1 flex items-center space-x-5">
        <span class="inline-block h-20 w-20 rounded-full overflow-hidden bg-gray-100">
            <!-- Display Current Profile Photo if no new photo is selected -->
            <div x-show="!photoPreview">
                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->fullname }}" class="rounded-full h-20 w-20 object-cover dark-hide">
                <img src="{{ $this->user->dark_profile_photo_url }}" alt="{{ $this->user->fullname }}" class="rounded-full h-20 w-20 object-cover border border-gray-600 dark-show">
            </div>

            <!-- Display New Profile Photo Preview when a file is selected -->
            <div x-show="photoPreview">
                <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center object-cover"
                    x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>
        </span>

        <!-- Button to Trigger File Input for Selecting a New Photo -->
        <button type="button"
            x-on:click.prevent="$refs.photo.click()"
            class="bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700
            hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500"
        >
            {{ __('Select A New Photo') }}
        </button>

        <!-- Button to Remove Current Profile Photo if it exists -->
        @if ($this->user->profile_photo_path)
            <button type="button"
                wire:click="deleteProfilePhoto"
                class="bg-white py-2 px-3 border border-red-300 rounded-md shadow-sm text-sm leading-4 font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            >
                {{ __('Remove Photo') }}
            </button>
        @endif

        <!-- Display Validation Error Message -->
        @error($attributes->whereStartsWith('wire:model')->first())
        <p wire:key="error_{{ $attributes->whereStartsWith('wire:model')->first() }}"
            class="form-input-container__input__error-message"
            id="error-{{ $attributes->whereStartsWith('wire:model')->first() }}"
        >
            {{ $message }}
        </p>
        @enderror
    </div>
</div>
