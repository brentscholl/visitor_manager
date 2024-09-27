@props([
    'index' => 0
])
<div class="relative">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300 border-dashed"></div>
    </div>
    <div class="relative flex justify-center">
        <button
                wire:click="$toggle('showComponents')"
                type="button"
                class="tour__locations--3 inline-flex items-center shadow-sm px-4 py-1.5 border border-dashed border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-secondary-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500"
        >
            <svg class="-ml-1.5 mr-1 h-5 w-5" x-description="Heroicon name: solid/plus-sm"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
            </svg>
            <span>Add Component</span>
        </button>
    </div>
    <x-modal type="add" wire:model="showComponents">
        <x-slot name="title">
            Add a Component
        </x-slot>
        <div class="flex space-x-3 mt-6">
            <div class="flex flex-col flex-grow-1 space-y-2 w-1/3">
                <p class="text-center px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Text Inputs</p>
                <button
                        wire:click="addComponent('text', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.a class="h-4 w-4"/>
                    <span>Text</span>
                </button>
                <button
                        wire:click="addComponent('email', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.envelope class="h-4 w-4"/>
                    <span>Email</span>
                </button>
                <button
                        wire:click="addComponent('phone', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.phone class="h-4 w-4"/>
                    <span>Phone</span>
                </button>
                <button
                        wire:click="addComponent('number', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.hashtag class="h-4 w-4"/>
                    <span>Number</span>
                </button>
                <button
                        wire:click="addComponent('paragraph', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.bars-3-bottom-left class="h-4 w-4"/>
                    <span>Paragraph</span>
                </button>
            </div>
            <div class="flex flex-col flex-grow-1 space-y-2 w-1/3">
                <p class="text-center px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Selections</p>
                <button
                        wire:click="addComponent('drop-down', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.queue-list class="h-4 w-4"/>
                    <span>Drop Down</span>
                </button>
                <button
                        wire:click="addComponent('checkboxes', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.check-square class="h-4 w-4"/>
                    <span>Checkboxes</span>
                </button>
                <button
                        wire:click="addComponent('radio-buttons', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.circle-dot class="h-4 w-4"/>
                    <span>Radio Buttons</span>
                </button>
                <button
                        wire:click="addComponent('consent', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.contract class="h-4 w-4"/>
                    <span>Consent</span>
                </button>
            </div>
            <div class="flex flex-col flex-grow-1 space-y-2 w-1/3">
                <p class="text-center px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Misc
                </p>
                <button
                        wire:click="addComponent('date', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.calendar class="h-4 w-4"/>
                    <span>Date</span>
                </button>
                <button
                        wire:click="addComponent('time', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.clock class="h-4 w-4"/>
                    <span>Time</span>
                </button>
                <button
                        wire:click="addComponent('divider', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.minus class="h-4 w-4"/>
                    <span>Divider</span>
                </button>

                <button
                        wire:click="addComponent('header', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.star class="h-4 w-4"/>
                    <span>Header</span>
                </button>
                <button
                        wire:click="addComponent('message', {{ $index }})"
                        type="button"
                        class="flex space-x-1 items-center justify-center w-full block px-3 py-2 rounded-md border border-secondary-500 text-center text-sm text-secondary-500 hover:bg-secondary-500 hover:text-white block s-transition"
                >
                    <x-svg.chat-bubble class="h-4 w-4"/>
                    <span>Message</span>
                </button>


            </div>
        </div>
        <x-slot name="footer">
            <x-button btn="simple" type="button" wire:click="$toggle('showComponents')">
                {{ __('Cancel') }}
            </x-button>
        </x-slot>
    </x-modal>
</div>
