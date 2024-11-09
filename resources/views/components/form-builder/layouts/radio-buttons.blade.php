@props([
    'i',
    'item',
])

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
