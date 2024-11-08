{{-- Main container for the Locations index page --}}
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
    {{-- List of locations wrapped in a styled container --}}
    <ul role="list" class="divide-y divide-gray-200 rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5 shadow-sm tour__welcome--2">
        {{-- Loop through each location and render a location row component --}}
        @foreach($locations as $location)
            {{-- Livewire component for rendering each location's row --}}
            @livewire('locations.location-row', ['location' => $location], key($location->id))
        @endforeach
    </ul>
</div>
