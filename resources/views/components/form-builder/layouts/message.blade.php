@props([
    'i',
])

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
