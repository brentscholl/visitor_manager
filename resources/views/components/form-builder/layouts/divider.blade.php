@props([
    'i',
    'item',
])

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
