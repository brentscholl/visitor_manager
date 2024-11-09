@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>

    <!-- Section Title Component -->
    <!-- Displays the title and description for the form section -->
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">

        <!-- Form Component -->
        <!-- Form is submitted via Livewire's submit event, linked to the specified submit method -->
        <form wire:submit="{{ $submit }}">

            <!-- Form Content Container -->
            <!-- Adds padding, shadow, and optional rounded corners based on the presence of actions -->
            <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <!-- Form Content Grid -->
                <!-- Arranges form fields in a 6-column responsive grid for better layout control -->
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            <!-- Form Actions (Optional) -->
            <!-- Displays action buttons if the actions slot is set -->
            <!-- Adds a footer with a gray background, padding, and shadow -->
            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif

        </form>
    </div>
</div>
