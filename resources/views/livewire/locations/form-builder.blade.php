<!-- This element is to trick the browser into centering the modal contents. -->
{{--            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>--}}
<div>
    <x-page-header class="max-w-7xl mx-auto sm:px-6 lg:px-8" title="Form Editor"
        description="Location: {{ $location->name }}">
        <x-slot name="svg">
            <x-svg.edit class="h-6 w-6 text-gray-500"/>
        </x-slot>
        <div class="flex items-center space-x-2">
            @if($isEditing && $layout)
            <a href="{{ route('locations.submissions', ['uuid' => $location->id]) }}"
                class=" inline-flex items-center px-2.5 py-1.5 space-x-1.5 border text-xs font-semibold uppercase tracking-widest rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 border-transparent text-white bg-blue-500 hover:bg-blue-700 focus:ring-blue-500 flex space-x-3 items-center">
                <x-svg.table-cells class="h-5 w-5"/>
                <span>View Submissions</span>
            </a>
                <x-button btn="primary" wire:click="$set('showConnectModal', true)" class="flex space-x-3 items-center">
                    <x-svg.tablet class="h-5 w-5"/>
                    <span>Connect to Tablet</span>
                </x-button>
                <x-modal wire:model.live="showConnectModal" type="blank">
                    <x-slot name="title">

                    </x-slot>

                    <div class="flex flex-col justify-center items-center space-y-6">
                        {!! QrCode::size(150)->generate( route('forms.show', ['uuid' => $location->id])); !!}
                        <p class="text-center text-lg">Scan the QR code above using your tablet.</p>
                        <p class="text-center text-sm">Or enter the following URL into your tablet's browser:</p>
                        <a href="{{ route('forms.show', ['uuid' => $location->id]) }}" target="_blank"
                            class="font-semibold text-center text-blue-500 hover:text-blue-600 transition ease-in-out duration-75">{{ route('forms.show', ['uuid' => $location->id]) }}</a>
                    </div>
                    <x-slot:footer>
                        <x-button btn="simple" type="button" wire:click="$toggle('showConnectModal')">
                            {{ __('Close') }}
                        </x-button>
                    </x-slot:footer>
                </x-modal>
            @endif
        </div>
    </x-page-header>
    <div class="flex flex-col min-w-0 flex-1 relative mx-6 mb-6"
        style="width: calc(100vw - 4rem); min-height: calc(80vh - 4rem);"
    >
        <div class="flex-1 relative flex items-start space-x-4 py-8">
            <!--**** BUILDER ****-->
            <div class="tour__locations--1 border bg-white sm:rounded-lg sm:shadow flex-shrink-0 w-full max-w-3xl relative pb-18">

                <div class="border-b border-gray-200 sm:rounded-t-lg bg-white px-4 py-5 sm:px-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Form Layout</h3>
                </div>

                <div class="flex flex-col justify-between">
                    <div class="p-3 space-y-4 pb-20">
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
                        @php($i = 0)
                        @if($layout)
                            @foreach($layout as $item)
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
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.a class="h-5 w-5"/>

                                                    <span>Text</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.placeholder"
                                                        id="layout-{{$i}}-inputs-placeholder"
                                                        :index="$i"
                                                        label="Placeholder"
                                                        placeholder="Write the placeholder for this text input"
                                                        :optional="true"
                                                    />

                                                    <x-input.checkbox-set :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                :index="$i"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                :index="$i"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                    </x-input.checkbox-set>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'email')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.envelope class="h-5 w-5"/>

                                                    <span>Email</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.placeholder"
                                                        id="layout-{{$i}}-inputs-placeholder"
                                                        :index="$i"
                                                        label="Placeholder"
                                                        placeholder="Write the placeholder for this Email input"
                                                        :optional="true"
                                                    />
                                                    <x-input.checkbox-set :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                :index="$i"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                :index="$i"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                    </x-input.checkbox-set>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'phone')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.phone class="h-5 w-5"/>

                                                    <span>Phone</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.placeholder"
                                                        id="layout-{{$i}}-inputs-placeholder"
                                                        :index="$i"
                                                        label="Placeholder"
                                                        placeholder="Write the placeholder for this Phone input"
                                                        :optional="true"
                                                    />
                                                    <x-input.checkbox-set :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                :index="$i"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                :index="$i"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                    </x-input.checkbox-set>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'number')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.hashtag class="h-5 w-5"/>

                                                    <span>Number</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />
                                                    <div class="col-span-1"></div>
                                                    <div class="col-span-1">
                                                        <x-input.checkbox
                                                            wire:model.live="layout.{{$i}}.inputs.use-min"
                                                            value="1"
                                                            label="Set a minimum amount"
                                                        />
                                                        @if($item['inputs']['use-min'])
                                                            <x-input.text
                                                                type="number"
                                                                class="col-span-1 mt-2"
                                                                wire:model.live="layout.{{$i}}.inputs.min"
                                                                id="layout-{{$i}}-inputs-label"
                                                                :index="$i"
                                                                label="Minimum"
                                                                min="0"
                                                            />
                                                        @endif
                                                    </div>
                                                    <div class="col-span-1">
                                                        <x-input.checkbox
                                                            wire:model.live="layout.{{$i}}.inputs.use-max"
                                                            value="1"
                                                            label="Set a maximum amount"
                                                        />
                                                        @if($item['inputs']['use-max'])
                                                            <x-input.text
                                                                type="number"
                                                                class="col-span-1 mt-2"
                                                                wire:model.live="layout.{{$i}}.inputs.max"
                                                                id="layout-{{$i}}-inputs-label"
                                                                :index="$i"
                                                                label="Maximum"
                                                                min="{{ $item['inputs']['min'] }}"
                                                            />
                                                        @endif
                                                    </div>

                                                    <x-input.checkbox-set :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                :index="$i"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                :index="$i"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                    </x-input.checkbox-set>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'paragraph')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.bars-3-bottom-left class="h-5 w-5"/>

                                                    <span>Paragraph</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.placeholder"
                                                        id="layout-{{$i}}-inputs-placeholder"
                                                        :index="$i"
                                                        label="Placeholder"
                                                        placeholder="Write the placeholder for this text input"
                                                        :optional="true"
                                                    />
                                                    <x-input.checkbox-set :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                :index="$i"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                :index="$i"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                    </x-input.checkbox-set>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'drop-down')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.queue-list class="h-5 w-5"/>

                                                    <span>Drop Down</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />
                                                    <div class="col-span-2">
                                                        @foreach($item['inputs']['options'] as $option)
                                                            <div class="mt-4 relative">
                                                                <x-input.text
                                                                    wire:model.defer="layout.{{ $i }}.inputs.options.{{ $loop->index }}"
                                                                    wire:key="layout_{{ $i }}_inputs_option_{{ $loop->index }}"
                                                                    label="Option"
                                                                    :required="true"
                                                                />
                                                                @if(! $loop->first)
                                                                    <button
                                                                        type="button"
                                                                        tooltip="Delete this option"
                                                                        tooltip-p="left"
                                                                        wire:click="removeOption('{{ $i }}','{{ $loop->index }}')"
                                                                        class="inline-flex text-xs w-5 h-5 p-1 absolute top-0 right-0 items-center border border-transparent rounded-full shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
                                                                    >
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-4 w-4"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                        <div class="mt-3 text-right">
                                                            <button
                                                                wire:click="addOption('{{ $i }}')"
                                                                type="button"
                                                                tooltip="Add an option"
                                                                tooltip-p="left"
                                                                class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-secondary-600 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500">
                                                                <svg class="h-5 w-5"
                                                                    x-description="Heroicon name: solid/plus"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20"
                                                                    fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <x-input.checkbox-set :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                :index="$i"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                :index="$i"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                    </x-input.checkbox-set>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'checkboxes')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.check-square class="h-5 w-5"/>

                                                    <span>Checkboxes</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />
                                                    <div class="col-span-2">
                                                        @foreach($item['inputs']['options'] as $option)
                                                            <div class="mt-4 relative">
                                                                <x-input.text
                                                                    wire:model.live="layout.{{ $i }}.inputs.options.{{ $loop->index }}"
                                                                    wire:key="layout_{{ $i }}_inputs_option_{{ $loop->index }}"
                                                                    label="Option"
                                                                    :required="true"
                                                                />
                                                                @if(! $loop->first)
                                                                    <button
                                                                        type="button"
                                                                        tooltip="Delete this option"
                                                                        tooltip-p="left"
                                                                        wire:click="removeOption('{{ $i }}','{{ $loop->index }}')"
                                                                        class="inline-flex text-xs w-5 h-5 p-1 absolute top-0 right-0 items-center border border-transparent rounded-full shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
                                                                    >
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-4 w-4"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                        <div class="mt-3 text-right">
                                                            <button
                                                                wire:click="addOption('{{ $i }}')"
                                                                type="button"
                                                                tooltip="Add another option"
                                                                tooltip-p="left"
                                                                class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-secondary-600 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500">
                                                                <svg class="h-5 w-5"
                                                                    x-description="Heroicon name: solid/plus"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20"
                                                                    fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <x-input.checkbox-set class="col-span-2" :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                        <x-input.checkbox
                                                            wire:model.live="layout.{{$i}}.inputs.inline"
                                                            id="layout-{{$i}}-inputs-inline"
                                                            value="1"
                                                            label="Inline"/>
                                                    </x-input.checkbox-set>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'radio-buttons')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.circle-dot class="h-5 w-5"/>

                                                    <span>Radio Buttons</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />
                                                    <div class="col-span-2">
                                                        @foreach($item['inputs']['options'] as $option)
                                                            <div class="mt-4 relative">
                                                                <x-input.text
                                                                    wire:model.live="layout.{{ $i }}.inputs.options.{{ $loop->index }}"
                                                                    wire:key="layout_{{ $i }}_inputs_option_{{ $loop->index }}"
                                                                    label="Option"
                                                                    :required="true"
                                                                />
                                                                @if(! $loop->first)
                                                                    <button
                                                                        type="button"
                                                                        tooltip="Delete this option"
                                                                        tooltip-p="left"
                                                                        wire:click="removeOption('{{ $i }}','{{ $loop->index }}')"
                                                                        class="inline-flex text-xs w-5 h-5 p-1 absolute top-0 right-0 items-center border border-transparent rounded-full shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
                                                                    >
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-4 w-4"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                        <div class="mt-3 text-right">
                                                            <button
                                                                wire:click="addOption('{{ $i }}')"
                                                                tooltip="Add an option"
                                                                tooltip-p="left"
                                                                type="button"
                                                                class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-secondary-600 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500">
                                                                <svg class="h-5 w-5"
                                                                    x-description="Heroicon name: solid/plus"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20"
                                                                    fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'consent')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.contract class="h-5 w-5"/>

                                                    <span>Consent</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.textarea
                                                        class="col-span-2"
                                                        wire:model.live="layout.{{$i}}.inputs.message"
                                                        id="layout-{{$i}}-inputs-message"
                                                        :index="$i"
                                                        label="Consenting message"
                                                        placeholder="ie. I agree to the terms and conditions."
                                                        :required="true"
                                                    />
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'date')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.calendar class="h-5 w-5"/>

                                                    <span>Date</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />

                                                    <x-input.checkbox-set :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                :index="$i"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                :index="$i"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                    </x-input.checkbox-set>
                                                    <span
                                                        class="col-span-2 flex space-x-2 items-center text-xs mt-2 text-gray-400">
                                                <x-svg.info-circle class="h-4 w-4"/><span>The form submission date is automatically recorded for your convenience. Utilize this input to gather other important dates as needed.</span>
                                            </span>

                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'time')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.clock class="h-5 w-5"/>

                                                    <span>Time</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.label"
                                                        id="layout-{{$i}}-inputs-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :required="true"
                                                    />

                                                    <x-input.checkbox-set :inline="true">
                                                        @if(! $item['inputs']['show-optional-flag'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.required"
                                                                id="layout-{{$i}}-inputs-required"
                                                                :index="$i"
                                                                value="1"
                                                                label="Required"/>
                                                        @endif
                                                        @if(! $item['inputs']['required'])
                                                            <x-input.checkbox
                                                                wire:model.live="layout.{{$i}}.inputs.show-optional-flag"
                                                                id="layout-{{$i}}-inputs-optional"
                                                                :index="$i"
                                                                value="1"
                                                                label="Show Optional Flag"/>
                                                        @endif
                                                    </x-input.checkbox-set>
                                                    <span
                                                        class="col-span-2 flex space-x-2 items-center text-xs mt-2 text-gray-400">
                                                <x-svg.info-circle class="h-4 w-4"/><span>The form submission time is automatically recorded for your convenience. Utilize this input to gather other important times as needed.</span>
                                            </span>

                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'divider')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.minus class="h-5 w-5"/>

                                                    <span>Divider</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-1"
                                                        wire:model.live="layout.{{$i}}.inputs.divide-label"
                                                        id="layout-{{$i}}-inputs-divide-label"
                                                        :index="$i"
                                                        label="Label"
                                                        :optional="true"
                                                        subtext="Leave blank for a horizontal line"
                                                    />

                                                    <span
                                                        class="col-span-2 flex space-x-2 items-center text-xs mt-2 text-gray-400">
                                                    <x-svg.info-circle class="h-4 w-4"/><span>Dividers do not require any input</span>
                                                </span>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'header')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.star class="h-5 w-5"/>

                                                    <span>Header</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.text
                                                        class="col-span-2"
                                                        wire:model.live="layout.{{$i}}.inputs.content"
                                                        id="layout-{{$i}}-inputs-header"
                                                        :index="$i"
                                                        label="Content"
                                                        :required="true"
                                                    />

                                                    <span
                                                        class="col-span-2 flex space-x-2 items-center text-xs mt-2 text-gray-400">
                                                    <x-svg.info-circle class="h-4 w-4"/><span>Headers do not require any input</span>
                                                </span>
                                                </div>
                                            </div>
                                        @endif

                                        @if($item['layout'] == 'message')
                                            <div>
                                                <div class="flex space-x-1 text-sm font-medium text-gray-500">
                                                    <x-svg.chat-bubble class="h-5 w-5"/>

                                                    <span>Message</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <x-input.textarea
                                                        class="col-span-2"
                                                        wire:model.live="layout.{{$i}}.inputs.message"
                                                        id="layout-{{$i}}-inputs-message"
                                                        :index="$i"
                                                        label="Message"
                                                        :required="true"
                                                    />

                                                    <span
                                                        class="col-span-2 flex space-x-2 items-center text-xs mt-2 text-gray-400">
                                                    <x-svg.info-circle class="h-4 w-4"/><span>Messages do not require any input</span>
                                                </span>
                                                </div>
                                            </div>
                                        @endif

                                        <!---- LAYOUTS END ---->
                                    </div>
                                </div>
                                @php($i++)
                            @endforeach
                        @else
                            <p class="flex justify-center items-center space-x-2 text-sm text-center text-gray-400 p-3 rounded-md border-dashed border">
                                <x-svg.alert class="h-4 w-4"/>
                                <span>No components in form. Please add a component.</span></p>
                        @endif
                        <x-locations.add-input-button :index="$i"/>
                    </div>
                </div>
                <div class=" bg-gray-50 text-right px-4 py-3 justify-end space-x-4 absolute bottom-0 w-full rounded-b">
                    @if($isEditing)
                        <x-button :disabled="!$changesMade" btn="primary" wire:click="updateForm"
                            wire:target="updateForm"
                            :loader="true" class="tour__locations--7">Update Form
                        </x-button>
                    @else
                        <x-button :disabled="!$changesMade" btn="primary" wire:click="createForm"
                            wire:target="createForm"
                            :loader="true" class="tour__locations--7">Create Form
                        </x-button>
                    @endif
                </div>
            </div>

            <!--**** PREVIEW ****-->
            <div class="tour__locations--2 border overflow-hidden bg-white sm:rounded-lg sm:shadow flex-1">

                <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Preview</h3>
                </div>

                <div class="p-3">
                    <div class="h-full overflow-y-auto rounded-md shadow-lg p-4 bg-gray-100 flex justify-center"
                        style="min-height: 400px">
                        <div class="w-full max-w-lg space-y-4">
                            @foreach($layout as $item)
                                @switch($item['layout'])
                                    @case('text')
                                        <x-input.text
                                            :disableErrors="true"
                                            id="preview-{{$i}}-input"
                                            label="{{ $item['inputs']['label'] }}"
                                            placeholder="{{ $item['inputs']['placeholder'] }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                        />
                                        @break
                                    @case('email')
                                        <x-input.text
                                            :disableErrors="true"
                                            type="email"
                                            id="preview-{{$i}}-input"
                                            label="{{ $item['inputs']['label'] }}"
                                            placeholder="{{ $item['inputs']['placeholder'] }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                        />
                                        @break
                                    @case('phone')
                                        <x-input.text
                                            :disableErrors="true"
                                            id="preview-{{$i}}-input"
                                            label="{{ $item['inputs']['label'] }}"
                                            placeholder="{{ $item['inputs']['placeholder'] }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                        />
                                        @break
                                    @case('number')
                                        <x-input.text
                                            :disableErrors="true"
                                            type="number"
                                            id="preview-{{$i}}-input"
                                            label="{{ $item['inputs']['label'] }}"
                                            min="{{  $item['inputs']['use-min'] ? $item['inputs']['min'] : 0 }}"
                                            max="{{  $item['inputs']['use-max'] ? $item['inputs']['max'] : 100000000000 }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                        />
                                        @break
                                    @case('paragraph')
                                        <x-input.textarea
                                            :disableErrors="true"
                                            id="preview-{{$i}}-input"
                                            label="{{ $item['inputs']['label'] }}"
                                            placeholder="{{ $item['inputs']['placeholder'] }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                        />
                                        @break
                                    @case('drop-down')
                                        <x-input.select
                                            :disableErrors="true"
                                            id="preview-{{$i}}-input"
                                            label="{{ $item['inputs']['label'] }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                        >
                                            <option value="" selected disabled>Select Option</option>
                                            @foreach($item['inputs']['options'] as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </x-input.select>
                                        @break
                                    @case('checkboxes')
                                        <x-input.checkbox-set
                                            id="preview-{{$i}}-input"
                                            label="{{ $item['inputs']['label'] }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                            :inline="$item['inputs']['inline']"
                                        >
                                            @foreach($item['inputs']['options'] as $option)
                                                <x-input.checkbox
                                                    id="preview-{{$i}}-input-{{ $loop->index }}"
                                                    value="{{ $option }}"
                                                    label="{{ $option }}"
                                                />
                                            @endforeach
                                        </x-input.checkbox-set>
                                        @break
                                    @case('radio-buttons')
                                        {{--            Use this to set the initial checked value. --}}
                                        @php($type_index = 0)
                                        @foreach($item['inputs']['options'] as $option)
                                            @if($option == $item['inputs']['label'])
                                                @php($type_index = $loop->index)
                                            @endif
                                        @endforeach
                                        <x-input.lg-radio-group
                                            id="preview-{{$i}}-input"
                                            label="{{ $item['inputs']['label'] }}"
                                            :index="$type_index"
                                        >
                                            @foreach($item['inputs']['options'] as $option)
                                                <x-input.lg-radio
                                                    id="preview-{{$i}}-input-{{ $loop->index }}"
                                                    value="{{ $option }}"
                                                >{{ $option }}</x-input.lg-radio>
                                            @endforeach
                                        </x-input.lg-radio-group>
                                        @break
                                    @case('consent')
                                        <x-input.checkbox
                                            id="preview-{{$i}}-input-{{ $loop->index }}"
                                            value="{{ $item['inputs']['message'] }}"
                                            label="{{ $item['inputs']['message'] }}"
                                        />
                                        @break
                                    @case('date')
                                        <x-input.date
                                            :disableErrors="true"
                                            label="{{ $item['inputs']['label'] }}"
                                            id="preview-{{$i}}-input-{{ $loop->index }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                        />
                                        @break
                                    @case('time')
                                        <x-input.time
                                            :disableErrors="true"
                                            id="preview-{{$i}}-input-{{ $loop->index }}"
                                            label="{{ $item['inputs']['label'] }}"
                                            :required="$item['inputs']['required']"
                                            :optional="$item['inputs']['show-optional-flag']"
                                        />
                                        @break

                                    @case('divider')
                                        <div class="relative">
                                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                <div class="w-full border-t border-gray-300"></div>
                                            </div>
                                            @if($item['inputs']['divide-label'])
                                                <div class="relative flex justify-center">
                                                <span
                                                    class="bg-gray-100 px-2 text-sm text-gray-500">{{ $item['inputs']['divide-label'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        @break

                                    @case('header')
                                        <h2 class="text-lg font-semibold">{{ $item['inputs']['content'] }}</h2>
                                        @break

                                    @case('message')
                                        <p>{{ $item['inputs']['message'] }}</p>
                                        @break
                                @endswitch
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- End main area -->
        </div>
    </div>
</div>
