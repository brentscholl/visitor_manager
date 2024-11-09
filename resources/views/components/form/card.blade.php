@props([
    'title' => '',        // Card title
    'description' => '',  // Card description text
    'actions' => '',      // Actions (like buttons) displayed at the bottom of the card
    'twoColumn' => false, // Whether the form layout is single or two-column
    'submit' => '',       // Form submission method (if applicable)
])

<div class="shadow rounded-md">
    <!-- Check if a form submit method is provided; wrap content in a form if true -->
    @if($submit)
        <form wire:submit="{{ $submit }}">
            @endif

            <!-- Card body container with conditional styling based on actions and layout -->
            <div class="bg-white py-6 px-4 sm:p-6
            @if($actions) rounded-t-md @else rounded-md @endif
            @if($twoColumn) md:grid md:grid-cols-3 md:gap-6 @else space-y-6 @endif "
            >
                <!-- Title and description section -->
                <div class="@if($twoColumn) md:col-span-1 @endif">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
                </div>

                <!-- Slot for the form fields/content -->
                <div class="@if($twoColumn) mt-0 md:col-span-2 @endif grid grid-cols-3 gap-6">
                    {{ $slot }}
                </div>
            </div>

            <!-- Actions section (optional), typically for buttons like 'Save' or 'Cancel' -->
            @if($actions)
                <div class="px-4 py-3 bg-gray-50 rounded-b-md text-right sm:px-6">
                    {{ $actions }}
                </div>
            @endif

            @if($submit)
        </form>
    @endif
</div>
