@props([
	'title',
	'description',
	'svg'
])
<header class="relative  pt-16 w-full">
    <div class="isolate">
        <div class="absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
            <div class="absolute left-16 top-full -mt-16 transform-gpu opacity-50 blur-3xl xl:left-1/2 xl:-ml-80">
                <div class="aspect-[1154/678] w-[72.125rem] bg-gradient-to-br from-[#3CBBF9] to-[#9089FC]" style="clip-path: polygon(100% 38.5%, 82.6% 100%, 60.2% 37.7%, 52.4% 32.1%, 47.5% 41.8%, 45.2% 65.6%, 27.5% 23.4%, 0.1% 35.3%, 17.9% 0%, 27.7% 23.4%, 76.2% 2.5%, 74.2% 56%, 100% 38.5%)"></div>
            </div>
            <div class="absolute inset-x-0 bottom-0 h-px bg-gray-900/5"></div>
        </div>
    </div>

    <div class="mx-auto w-full px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-2xl items-center justify-between gap-x-8 lg:mx-0 lg:max-w-none">
            <div class="flex items-center gap-x-6">
                @if(isset($svg))
                    <div class="h-10 w-10 flex justify-center items-center rounded-full ring-1 ring-gray-900/10">
                        {{ $svg }}
                    </div>
                @endif
                <h1>
                    @if(isset($description))
                        <div class="text-sm leading-6 text-gray-500">{{ $description }}</div>
                    @endif
                    <div class="mt-1 text-base font-semibold leading-6 text-gray-900">{{ $title }}</div>
                </h1>
            </div>
            <div class="flex items-center gap-x-4 sm:gap-x-6 relative">
                {{ $slot }}
            </div>
        </div>
    </div>
</header>

