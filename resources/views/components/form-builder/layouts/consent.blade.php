@props([
    'i',
    'item',
])

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
