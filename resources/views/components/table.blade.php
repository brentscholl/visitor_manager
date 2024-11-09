@props([
    'collection' => null,     // Collection of items to display in the table
    'emptyStatement' => null,  // Message to display when the table is empty
])

<div class="{{ $attributes->get('class') }}">
    {{-- Render controls if provided --}}
    @if(isset($controls))
        <div class="grid grid-cols-12 mb-4 space-x-2 tour__submissions--1">
            {{ $controls }}
        </div>
    @endif

    {{-- Check if the collection has items or if no empty statement is provided --}}
    @if(optional($collection)->count() > 0 || ! $emptyStatement)
        <div class="flex flex-col">
            <div class="-my-2 pt-2 pb-8 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 sm:rounded-lg">
                <div class="align-middle inline-block min-w-full border shadow sm:rounded-lg relative">
                    <table class="p-table table-fixed">
                        <thead>
                        <tr>
                            {{ $head }} {{-- Table headers passed from parent component --}}
                        </tr>
                        </thead>
                        <tbody>
                        {{ $slot }} {{-- Table body content passed from parent component --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Render pagination links if available --}}
        {{ optional($collection)->links() }}

    @else
        {{-- Display an empty state message when there are no items to show --}}
        <div class="rounded-md border-2 border-dashed px-6 border-gray-300 overflow-hidden sm:rounded-md">
            <p class="text-gray-400 my-8 text-center">
                {{ $emptyStatement }} {{-- Message shown when the table is empty --}}
            </p>
        </div>
    @endif
</div>
