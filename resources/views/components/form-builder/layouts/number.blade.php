@props([
    'i',
    'item'
])

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
