@props([
    'collection' => null,
    'emptyStatement' => null,
])
<div class="{{ $attributes->get('class') }}">
    @if(isset($controls))
        <div class="grid grid-cols-12 mb-4 space-x-2 tour__submissions--1">
            {{ $controls }}
        </div>
    @endif
    @if(optional($collection)->count() > 0 || ! $emptyStatement)
    <div class="flex flex-col">
        <div class="-my-2 pt-2 pb-8 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 sm:rounded-lg">
            <div class="align-middle inline-block min-w-full border shadow sm:rounded-lg relative">
                <table class="p-table table-fixed">
                    <thead>
                    <tr>
                        {{ $head }}
                    </tr>
                    </thead>
                    <tbody>
                        {{ $slot }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ optional($collection)->links() }}
    @else
        <div class="rounded-md border-2 border-dashed px-6 border-gray-300 overflow-hidden sm:rounded-md">
            <p class="text-gray-400 my-8 text-center">
                {{ $emptyStatement }}
            </p>
        </div>
    @endif
</div>
