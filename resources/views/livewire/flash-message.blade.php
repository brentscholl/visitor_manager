{{-- Flash message component for displaying notifications --}}
<div>
    @if($shown)
        {{-- Check if the message is a notice and display an overlay modal --}}
        @if(isset($styles['isNotice']))
            <div x-data="{ open: true }" @keydown.window.escape="open = false" x-show="open"
                class="relative" style="z-index:999;" aria-labelledby="modal-title" x-ref="dialog" aria-modal="true">

                {{-- Background overlay for the modal --}}
                <div x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-description="Background backdrop, show/hide based on modal state."
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-2"></div>

                {{-- Modal container --}}
                <div class="fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-start justify-center min-h-full p-4 text-center sm:p-0">
                        <div x-show="open"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-description="Modal panel, show/hide based on modal state."
                            class="relative bg-red-50 border border-red-500 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-sm sm:w-full sm:p-6"
                            @click.away="open = false">

                            <div class="flex flex-col items-center">
                                <div class="mx-auto grow-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-500" x-description="Heroicon name: outline/exclamation" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <h3 class="text-lg leading-6 font-medium text-red-500" id="modal-title">Notice</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            {!! $message['message'] !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 text-center sm:mt-6">
                                <x-button @click="open = false">Close</x-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Check if the message is a success overlay --}}
        @elseif(isset($styles['isSuccessOverlay']))
            <div x-data="{ open: true }" @keydown.window.escape="open = false" x-show="open"
                class="relative" style="z-index:999;" aria-labelledby="modal-title" x-ref="dialog" aria-modal="true">

                <div x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-description="Background backdrop, show/hide based on modal state."
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-2"></div>

                <div class="fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-start justify-center min-h-full p-4 text-center sm:p-0">

                        <div x-show="open"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-description="Modal panel, show/hide based on modal state."
                            class="relative bg-emerald-50 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-sm sm:w-full sm:p-6"
                            @click.away="open = false">

                            <div class="flex flex-col items-center">
                                <div class="mx-auto grow-0 flex items-center justify-center h-12 w-12 rounded-full border-2 border-emerald-500 bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <x-svg.check class="h-6 w-6 text-emerald-500" />
                                </div>
                                <div class="text-center mt-2">
                                    <div class="mt-2">
                                        <h3 class="text-emerald-500">{!! $message['message'] !!}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6">
                                <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm" @click="open = false">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- For regular messages that are not overlays --}}
        @else
            <div x-data="{ open: false, hover: false, timeout: null }"
                x-init="
                    timeout = setTimeout(() => {
                        if (!hover) {
                            open = false;
                        }
                    }, 7000);
                    open = true;
                 "
                x-show="open"
                x-on:mouseover="hover = true; clearTimeout(timeout)"
                x-on:mouseout="hover = false; timeout = setTimeout(() => { open = false }, 7000)"
                x-description="Notification panel, show/hide based on alert state."
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="w-full mb-3 {{ $styles['bg-color'] }} border {{ $styles['border-color'] }} shadow-lg p-transition hover:shadow-2xl rounded-lg pointer-events-auto"
                style="z-index: 999;"
            >
                <div class="rounded-lg shadow-xs overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-center">
                            @if ($styles['icon'] ?? false)
                                <div class="grow-0">
                                    <p class="{{ $styles['icon-color'] }}">
                                        <x-dynamic-component :component="'svg.' . $styles['icon']" class="w-5 h-5"/>
                                    </p>
                                </div>
                            @endif
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm leading-5 font-medium {{ $styles['text-color'] }}">
                                    {!! $message['message'] !!}
                                </p>
                            </div>
                            {{-- Dismiss button --}}
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5">
                                    <button class="inline-flex rounded-md p-1.5 {{ $styles['text-color'] }} focus:outline-none transition ease-in-out opacity-50 duration-150 hover:opacity-100" wire:click="dismiss">
                                        <x-svg.x class="h-4 w-4"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
