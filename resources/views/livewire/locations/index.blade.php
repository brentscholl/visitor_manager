<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
<ul role="list" class="divide-y divide-gray-200 rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5 shadow-sm tour__welcome--2">
    @foreach($locations as $location)
        @livewire('locations.location-row', ['location' => $location], key($location->id))
    @endforeach
</ul>
</div>
