<nav class="flex mb-3" aria-label="Breadcrumb">
    <ol class="w-full mx-auto flex space-x-4">
        <li class="flex">
            <div class="flex items-center">
                <a tooltip="Dashboard" tooltip-p="bottom" href="{{ route('dashboard') }}" class="text-gray-400 hover:text-secondary-500 dark:text-gray-600 dark:hover:text-secondary-500">
                    <x-svg.home class="grow-0 h-5 w-5" />
                    <span class="sr-only">Home</span>
                </a>
            </div>
        </li>
        {{ $slot }}

    </ol>
</nav>
