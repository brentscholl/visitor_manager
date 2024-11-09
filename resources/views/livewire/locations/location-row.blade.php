{{-- Row component for displaying individual location details in a list --}}
<li class="flex items-center justify-between gap-x-6 py-5 px-3 transition ease-in-out duration-75 hover:bg-blue-50 group">
    {{-- Link to the detailed view of the location --}}
    <a href="{{ route('locations.show', ['id' => $location->id]) }}" class="flex-grow cursor-pointer min-w-0">
        <div class="flex items-start gap-x-3">
            <p class="text-lg font-semibold leading-6 text-gray-900 group-hover:text-blue-500 transition ease-in-out duration-75">{{ $location->name }}</p>
        </div>
        <div class="mt-1 flex items-center gap-x-2 leading-5 text-gray-500">
            <p class="whitespace-nowrap text-xs">Created on
                <time datetime="{{ $location->created_at->format('Y-m-d') }}">{{ $location->created_at->format('F j, Y') }}</time>
            </p>
            <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
                <circle cx="1" cy="1" r="1"/>
            </svg>
            <p class="truncate text-xs">Created by {{ $location->user->name }}</p>
        </div>
    </a>

    <div class="flex items-center space-x-4">
        {{-- Link to edit the location --}}
        <a href="{{ route('locations.show', ['id' => $location->id]) }}" tooltip="Edit Form"
            class="tour__welcome--3 inline-flex items-center px-2.5 py-1.5 space-x-1.5 border border-gray-500 text-xs font-semibold uppercase tracking-widest rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 text-gray-500 bg-transparent hover:border-blue-500 hover:text-blue-500 focus:ring-blue-500 flex space-x-3 items-center">
            <x-svg.edit class="h-4 w-4"/>
        </a>

        {{-- Conditional rendering for submission view and connect button based on layout availability --}}
        @if($hasLayout)
            <a href="{{ route('locations.submissions', ['id' => $location->id]) }}" tooltip="View Submissions"
                class="tour__welcome--4 inline-flex items-center px-2.5 py-1.5 space-x-1.5 border text-xs font-semibold uppercase tracking-widest rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 border-transparent text-white bg-blue-500 hover:bg-blue-700 focus:ring-blue-500 flex space-x-3 items-center">
                <x-svg.table-cells class="h-4 w-4"/>
            </a>

            {{-- Button to connect to tablet with QR code modal --}}
            <x-button btn="primary" wire:click="$set('showConnectModal', true)" class="tour__welcome--5 flex space-x-3 items-center" tooltip="Connect to tablet">
                <x-svg.tablet class="h-4 w-4"/>
            </x-button>

            <x-modal wire:model.live="showConnectModal" type="blank">
                <x-slot name="title"></x-slot>
                <div class="flex flex-col justify-center items-center space-y-6">
                    {{-- Display QR code for connecting --}}
                    {!! QrCode::size(150)->generate( route('forms.show', ['code' => $location->location_code])); !!}
                    <p class="text-center text-lg">Scan the QR code above using your tablet.</p>
                    <p class="text-center text-sm">Or enter the following URL into your tablet's browser:</p>
                    <a href="{{ route('forms.show', ['code' => $location->location_code]) }}" target="_blank"
                        class="font-semibold text-center text-blue-500 hover:text-blue-600 transition ease-in-out duration-75">{{ route('forms.show', ['code' => $location->location_code]) }}</a>
                </div>
                <x-slot:footer>
                    <x-button btn="simple" type="button" wire:click="$toggle('showConnectModal')">
                        {{ __('Close') }}
                    </x-button>
                </x-slot:footer>
            </x-modal>
        @endif

        <div class="relative">
            {{-- Dropdown menu for additional options --}}
            <x-menu.three-dot :inline="true" :showMenuContent="$showMenuContent">
                {{-- Rename location option --}}
                <button type="button" wire:click="$toggle('renameLocation')"
                    class="block w-full text-left px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 hover:text-blue-900">
                    Rename
                </button>

                {{-- Rename location modal --}}
                <x-modal wire:model.live="renameLocation" type="edit">
                    <x-input.text
                        wire:model="name"
                        value="{{ $location->name }}"
                        label="Location Name"
                        placeholder="Type Location Name..."
                        :required="true"
                    />
                    <x-slot name="footer">
                        <x-button btn="simple" type="button" wire:click="$toggle('renameLocation')">
                            {{ __('Cancel') }}
                        </x-button>
                        <x-button btn="primary" type="button" class="ml-2" wire:click="changeLocationName">
                            {{ __('Rename') }}
                        </x-button>
                    </x-slot>
                </x-modal>

                {{-- Remove location option --}}
                <button type="button" wire:click="$toggle('deleteLocation')"
                    class="block w-full text-left px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-100 hover:text-red-900">
                    Remove
                </button>

                {{-- Confirmation modal for deleting location --}}
                <x-modal wire:model.live="deleteLocation" type="danger">
                    Are you sure you want to remove this Location?
                    <div class="text-black font-semibold">
                        {{ $location->name }}
                    </div>
                    <x-slot name="footer">
                        <x-button btn="simple" type="button" wire:click="$toggle('deleteLocation')">
                            {{ __('Cancel') }}
                        </x-button>
                        <x-button btn="danger" type="button" class="ml-2" wire:click="removeLocation()">
                            {{ __('Remove') }}
                        </x-button>
                    </x-slot>
                </x-modal>
            </x-menu.three-dot>
        </div>
    </div>
</li>
