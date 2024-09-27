<x-app-layout>
    @include('tours.locations-tour')
    @livewire('locations.form-builder', ['location' => $location])
</x-app-layout>
