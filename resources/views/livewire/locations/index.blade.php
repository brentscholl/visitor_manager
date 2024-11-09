{{-- Main container for the Locations index page --}}
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
    @if($locations->isEmpty())
        {{-- If there are no locations, show a message --}}
        <div class="text-center w-full rounded border border-dashed border-2 px-6 py-10 flex flex-col justify-center items-center">
            <x-svg.info-circle class="w-8 h-8 text-gray-300"/>
            <h4 class="text-gray-900 mt-4 text-sm">No locations</h4>
            <p class="text-gray-500 mt-2 text-sm">Get started by adding a new location</p>
            <x-button class="mt-6" wire:click="addLocation">
                <x-svg.plus-circle class="h-5 w-5 mr-2"/>
                Add Location
            </x-button>
        </div>
    @else
        {{-- List of locations wrapped in a styled container --}}
        <ul role="list" class="divide-y divide-gray-200 rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5 shadow-sm tour__welcome--2">
            {{-- Loop through each location and render a location row component --}}
            @foreach($locations as $location)
                {{-- Livewire component for rendering each location's row --}}
                @livewire('locations.location-row', ['location' => $location], key($location->id))
            @endforeach
        </ul>
    @endif
</div>
