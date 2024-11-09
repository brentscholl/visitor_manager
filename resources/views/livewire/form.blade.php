{{-- Form component for submitting data at a specific location --}}
<div class="px-4 py-20 bg-gray-100 flex justify-center" style="min-height: 100vh">

    {{-- Show QR Code modal if visitor device sign-in is enabled --}}
    @if($location->settings()->get('enableVisitorDeviceSignIn', true))
        <x-modal wire:model="showQRCode">
            <x-slot name="title"></x-slot>
            <div class="flex flex-col justify-center items-center space-y-6">
                {{-- Generate and display the QR code for the location --}}
                {!! QrCode::size(150)->generate(route('forms.show', ['code' => $location->location_code, 'isVisitor' => 'true'])); !!}
                <p class="text-center text-lg max-w-lg">To complete the form using your personal device, please scan the QR code displayed above.</p>
                <p class="text-center text-sm">Alternatively, you can complete the form on this device.</p>
            </div>
            <x-slot name="footer">
                <div class="flex justify-center w-full">
                    <x-button btn="primary" type="button" wire:click="$set('showQRCode', false)">
                        {{ __('Fill out form on this device') }}
                    </x-button>
                </div>
            </x-slot>
        </x-modal>
    @endif

    <div class="w-full max-w-lg space-y-4">
        <div class="flex justify-end items-center">
            {{-- Button to toggle QR code modal for personal devices --}}
            @if($location->settings()->get('enableVisitorDeviceSignIn', true))
                <x-button btn="simple" type="button" wire:click="$toggle('showQRCode')">
                    {{ __('Fill out form on your device') }}
                </x-button>
            @endif
        </div>

        {{-- Loop through the layout components and render inputs accordingly --}}
        @foreach($layout as $i => $item)
            <x-form-builder.form-item :item="$item" :i="$i" wireModel="form.{{ $item['id'] }}.value"/>
        @endforeach

        {{-- Display any form validation errors --}}
        @if($errors->all())
            <div class="bg-red-100 py-2 pl-3 pr-8 rounded-md relative mb-2">
                <p class="text-red-500 mb-3">Please correct these errors before submitting.</p>
                <ul class="text-xs list-disc">
                    @foreach($errors->all() as $message)
                        <li class="text-red-500">{{ $message }}</li>
                    @endforeach
                </ul>
                <div class="text-red-500 absolute top-2 right-2">
                    <x-svg.error class="h-4 w-4"/>
                </div>
            </div>
        @endif

        <div class="mt-6 flex items-center justify-end gap-x-6">
            {{-- Button to clear the form --}}
            <x-button btn="simple" type="button" wire:click="$toggle('showClearForm')">
                {{ __('Clear Form') }}
            </x-button>
            <x-modal wire:model.live="showClearForm" type="danger">
                Are you sure you want to clear this form of all your responses?
                <x-slot name="footer">
                    <x-button btn="simple" type="button" wire:click="$toggle('showClearForm')">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button btn="danger" type="button" class="ml-2" wire:click="cancel">
                        {{ __('Clear Form') }}
                    </x-button>
                </x-slot>
            </x-modal>

            {{-- Button to submit the form --}}
            <x-button btn="primary" :loader="true" wire:target="submit" type="button" class="ml-2" wire:click="submit">
                {{ __('Submit') }}
            </x-button>
        </div>
    </div>
</div>
