@props([
    'i',
    'item'
])
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
