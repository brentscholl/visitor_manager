<div class="md:flex md:items-center md:justify-between">
    <x-page-header title="Locations">
        <x-slot name="svg">
            {{-- Icon for the locations page header --}}
            <x-svg.map-marker class="h-6 w-6 text-gray-500"/>
        </x-slot>

        {{-- Button to toggle the modal for adding a new location --}}
        <x-button btn="primary" wire:click="$toggle('showCreateModal')" class="tour__welcome--1">
            <x-svg.plus-circle class="h-5 w-5 mr-2"/>
            Add Location
        </x-button>

        {{-- Modal for creating a new location --}}
        <x-modal wire:model.live="showCreateModal" submit="createLocation" type="add">
            <x-slot name="title">
                Add Location {{-- Title of the modal --}}
            </x-slot>

            {{-- Input field for the location name --}}
            <x-input.text
                label="Name"
                placeholder="Location Name"
                wire:model="name"
            />

            <x-slot name="footer">
                {{-- Cancel button to close the modal --}}
                <x-button btn="simple" type="button" wire:click="$set('showCreateModal', false)">
                    {{ __('Cancel') }}
                </x-button>

                {{-- Submit button to create the new location --}}
                <x-button btn="primary" :loader="true" type="submit" class="ml-2">
                    {{ __('Add') }}
                </x-button>
            </x-slot>
        </x-modal>
    </x-page-header>
</div>
