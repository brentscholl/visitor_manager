{{-- Page Header --}}
<div>
    <x-page-header class="max-w-7xl mx-auto sm:px-6 lg:px-8" title="Form Editor" description="Location: {{ $location->name }}">
        <x-slot name="svg">
            {{-- Icon for the form editor --}}
            <x-svg.edit class="h-6 w-6 text-gray-500"/>
        </x-slot>

        {{-- Action Buttons --}}
        <div class="flex items-center space-x-2">
            @if($isEditing && $layout)
                {{-- Button to view form submissions --}}
                <a href="{{ route('locations.submissions', ['id' => $location->id]) }}" class="inline-flex items-center px-2.5 py-1.5 space-x-1.5 bg-blue-500 hover:bg-blue-700 text-white font-semibold text-xs uppercase tracking-widest rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex space-x-3 items-center">
                    <x-svg.table-cells class="h-5 w-5"/>
                    <span>View Submissions</span>
                </a>

                {{-- Button to open modal for tablet connection --}}
                <x-button btn="primary" wire:click="$set('showConnectModal', true)" class="flex space-x-3 items-center">
                    <x-svg.tablet class="h-5 w-5"/>
                    <span>Connect to Tablet</span>
                </x-button>
            @endif
        </div>
    </x-page-header>

    {{-- Connect to Tablet Modal --}}
    @if($isEditing && $layout)
        <x-modal wire:model.live="showConnectModal" type="blank">
            <x-slot name="title">
                {{-- Title for the connect modal (optional) --}}
            </x-slot>

            {{-- QR Code and Instructions --}}
            <div class="flex flex-col justify-center items-center space-y-6">
                {!! QrCode::size(150)->generate(route('forms.show', ['code' => $location->location_code])); !!}
                <p class="text-center text-lg">Scan the QR code above using your tablet.</p>
                <p class="text-center text-sm">Or enter the following URL into your tablet's browser:</p>
                <a href="{{ route('forms.show', ['code' => $location->location_code]) }}" target="_blank" class="font-semibold text-center text-blue-500 hover:text-blue-600 transition ease-in-out duration-75">{{ route('forms.show', ['code' => $location->location_code]) }}</a>
            </div>

            <x-slot:footer>
                {{-- Close button for the modal --}}
                <x-button btn="simple" type="button" wire:click="$toggle('showConnectModal')">
                    {{ __('Close') }}
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif

    {{-- Main Content --}}
    <div class="flex flex-col min-w-0 flex-1 relative mx-6 mb-6" style="width: calc(100vw - 4rem); min-height: calc(80vh - 4rem);">
        <div class="flex-1 relative flex items-start space-x-4 py-8">

            {{-- Form Builder Section --}}
            <div class="tour__locations--1 border bg-white sm:rounded-lg sm:shadow flex-shrink-0 w-full max-w-3xl relative pb-18">
                {{-- Header for Form Layout --}}
                <div class="border-b border-gray-200 sm:rounded-t-lg bg-white px-4 py-5 sm:px-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Form Layout</h3>
                </div>

                <div class="flex flex-col justify-between">
                    <div class="p-3 space-y-4 pb-20">
                        {{-- QR Code Toggle Section --}}
                        <div class="rounded border p-4 space-y-4 divide">
                            <div class="flex justify-between space-x-2 tour__locations--6">
                                <span class="text-sm text-gray-500">Enable QR code for visitor to sign in with their device</span>
                                <x-toggle
                                    :enabled="$enableVisitorDeviceSignIn"
                                    entangle="enableVisitorDeviceSignIn"
                                    tooltipEnabled="The QR code will be displayed on the tablet for visitors to scan and sign in with their device."
                                    tooltipDisabled="The QR code will not be displayed on the tablet for visitors to scan and sign in with their device."
                                    wire:click="toggleEnableVisitorDeviceSignIn"
                                />
                            </div>
                        </div>

                        {{-- Loop through form components --}}
                        @php($i = 0)
                        @if($layout)
                            @foreach($layout as $item)
                                <x-form-builder.layout-item
                                    :item="$item"
                                    :i="$i"
                                    :layout="$layout"
                                    :showDeleteComponentModal="$showDeleteComponentModal"
                                />
                                @php($i++)
                            @endforeach
                        @else
                            {{-- Display when no components are present --}}
                            <p class="flex justify-center items-center space-x-2 text-sm text-center text-gray-400 p-3 rounded-md border-dashed border">
                                <x-svg.alert class="h-4 w-4"/>
                                <span>No components in form. Please add a component.</span>
                            </p>
                        @endif
                        <x-locations.add-input-button :index="$i"/>
                    </div>
                </div>

                {{-- Form Controls --}}
                <div class="bg-gray-50 text-right px-4 py-3 justify-end space-x-4 absolute bottom-0 w-full rounded-b">
                    @if($isEditing)
                        {{-- Button to update form --}}
                        <x-button :disabled="!$changesMade" btn="primary" wire:click="updateForm" wire:target="updateForm" :loader="true" class="tour__locations--7">
                            Update Form
                        </x-button>
                    @else
                        {{-- Button to create form --}}
                        <x-button :disabled="!$changesMade" btn="primary" wire:click="createForm" wire:target="createForm" :loader="true" class="tour__locations--7">
                            Create Form
                        </x-button>
                    @endif
                </div>
            </div>

            {{-- Preview Section --}}
            <div class="tour__locations--2 border overflow-hidden bg-white sm:rounded-lg sm:shadow flex-1">
                {{-- Header for preview --}}
                <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Preview</h3>
                </div>

                {{-- Preview Content --}}
                <div class="p-3">
                    <div class="h-full overflow-y-auto rounded-md shadow-lg p-4 bg-gray-100 flex justify-center" style="min-height: 400px">
                        <div class="w-full max-w-lg space-y-4">
                            @php($i = 0)
                            @foreach($layout as $item)
                                <x-form-builder.form-item :item="$item" :i="$i"/>
                                @php($i++)
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- End main area --}}
        </div>
    </div>
</div>
