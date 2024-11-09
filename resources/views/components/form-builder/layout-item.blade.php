@props([
    'item',
    'i',
    'layout',
    'showDeleteComponentModal'
])

    <div
        class="tour__locations--4 border flex relative space-x-2 py-2 pr-2 rounded-md bg-gray-50 transition-all shadow-sm">
        @if($item['id'])
            <button
                type="button"
                title="Remove"
                wire:click="$toggle('showDeleteComponentModal')"
                tooltip="Delete this component"
                tooltip-p="left"
                class="absolute top-0.5 right-0.5 h-4 w-4 p-0.5 rounded-full bg-red-500 text-white opacity-50 hover:opacity-100 focus:outline-none"
            >
                <x-svg.x/>
            </button>
            <x-modal wire:model.live="showDeleteComponentModal" type="danger">
                Are you sure you want to remove this component? Any data you've collected
                associated with this component will be lost. This action cannot be undone.
                <x-slot name="footer">
                    <x-button btn="simple" type="button"
                        wire:click="$toggle('showDeleteComponentModal')">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button btn="danger" type="button" class="ml-2"
                        wire:click="deleteComponent({{ $i }}, {{ $item['id'] }})">
                        {{ __('Remove') }}
                    </x-button>
                </x-slot>
            </x-modal>
        @else
            <button
                type="button"
                title="Remove"
                wire:click="removeComponent({{ $i }})"
                class="absolute h-4 w-4 p-0.5 rounded-full bg-red-500 text-white opacity-50 hover:opacity-100 focus:outline-none"
                style="top: -0.1rem; right: -0.3rem;">
                <x-svg.x/>
            </button>
        @endif
        <div class="tour__locations--5 flex flex-col justify-between space-y-2 h-full">
            @if($i == 0)
                <div></div>
            @else
                <button type="button" wire:click="moveComponent('up', {{ $i }})"
                    tooltip="Move this component up"
                    tooltip-p="right"
                    class="flex items-center rounded-full p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-200 s-transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                    </svg>
                </button>
            @endif

            @if($i == (count($layout) - 1))
                <div></div>
            @else
                <button type="button" wire:click="moveComponent('down', {{ $i }})"
                    tooltip="Move this component down"
                    tooltip-p="right"
                    class="flex items-center rounded-full p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-200 s-transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                    </svg>
                </button>
            @endif
        </div>

        <!-- =================================================================== -->
        <!-- ************************ LAYOUTS ********************************** -->
        <!-- =================================================================== -->
        <div class="flex-grow-1 w-full">
            @if($item['layout'] == 'text')
                <x-form-builder.layouts.text :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'email')
                <x-form-builder.layouts.email :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'phone')
                <x-form-builder.layouts.phone :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'number')
                <x-form-builder.layouts.number :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'paragraph')
                <x-form-builder.layouts.paragraph :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'drop-down')
                <x-form-builder.layouts.drop-down :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'checkboxes')
                <x-form-builder.layouts.checkboxes :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'radio-buttons')
                <x-form-builder.layouts.radio-buttons :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'consent')
                <x-form-builder.layouts.consent :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'date')
                <x-form-builder.layouts.date :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'time')
                <x-form-builder.layouts.time :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'divider')
                <x-form-builder.layouts.divider :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'header')
                <x-form-builder.layouts.header :item="$item" :i="$i"/>
            @endif

            @if($item['layout'] == 'message')
                <x-form-builder.layouts.message :item="$item" :i="$i"/>
            @endif

            <!---- LAYOUTS END ---->
        </div>
    </div>
