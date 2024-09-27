<x-app-layout>
    @include('tours.submissions-tour')
    @livewire('locations.submissions', ['location' => $location])
</x-app-layout>
