@props(['id', 'maxWidth','type' => '', 'submit' => ''])

@php
    $id = $id ?? md5($attributes->wire('model'));

    switch ($maxWidth ?? '2xl') {
        case 'sm':
            $maxWidth = 'sm:max-w-sm';
            break;
        case 'md':
            $maxWidth = 'sm:max-w-md';
            break;
        case 'lg':
            $maxWidth = 'sm:max-w-lg';
            break;
        case 'xl':
            $maxWidth = 'sm:max-w-xl';
            break;
            case '7xl':
            $maxWidth = 'sm:max-w-7xl';
            break;
        case '2xl':
        default:
            $maxWidth = 'sm:max-w-2xl';
            break;
    }
@endphp

<div x-data="{
        show: @entangle($attributes->wire('model')).live,
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input, textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'

            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    id="{{ $id }}"
    class="fixed top-0 inset-x-0 px-4 pt-6 z-50 sm:flex sm:items-top sm:justify-center"
    style="display: none;"
>
    <div x-show="show"
        class="fixed inset-0 transform transition-all backdrop-blur-2"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div x-show="show" class="bg-white rounded-lg overflow-auto shadow-xl transform transition-all sm:w-full {{ $maxWidth }}"
         style="max-height: calc(100vh - 1.5rem)"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        @if($submit)
            <form wire:submit="{{ $submit }}">
        @endif
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                @switch($type)
                    @case('danger')
                        <div class="mx-auto grow-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-500" x-description="Heroicon name: outline/exclamation" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        @break
                    @case('add')
                        <div class="mx-auto grow-0 flex items-center justify-center h-12 w-12 rounded-full bg-secondary-100 sm:mx-0 sm:h-10 sm:w-10">
                            <x-svg.plus-circle class="h-6 w-6 text-secondary-500"/>
                        </div>
                        @break
                    @case('send')
                        <div class="mx-auto grow-0 flex items-center justify-center h-12 w-12 rounded-full bg-secondary-100 sm:mx-0 sm:h-10 sm:w-10">
                            <x-svg.send class="h-6 w-6 text-secondary-500"/>
                        </div>
                        @break
                    @case('cancel')
                        <div class="mx-auto grow-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <x-svg.cancel class="h-6 w-6 text-red-500"/>
                        </div>
                        @break
                    @case('info')
                        <div class="mx-auto grow-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <x-svg.info-circle class="h-6 w-6 text-blue-500"/>
                        </div>
                        @break
                    @case('success')
                        <div class="mx-auto grow-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                            <x-svg.check-circle class="h-6 w-6 text-emerald-500"/>
                        </div>
                        @break
                    @default()

                        @break
                @endswitch
                <div class="mt-3 grow text-center sm:mt-0 sm:ml-4 sm:text-left">
                    @if(isset($title))
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {!! $title !!}
                        </h3>
                    @endif
                    <div class="mt-2 max-h-full">
                        <p class="text-sm text-gray-500">
                            {{ $slot }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 text-right px-4 py-3 justify-end space-x-4">
            {{ $footer }}
        </div>
        @if($submit)
            </form>
        @endif
    </div>
</div>
