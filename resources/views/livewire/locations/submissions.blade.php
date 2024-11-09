{{-- Submissions page for displaying the submitted data for a specific location --}}
<div x-data x-init="
    let timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    console.log('Detected Timezone:', timezone);
    @this.call('setTimezone', timezone)
">
    {{-- Page header with title and description --}}
    <x-page-header class="max-w-7xl mx-auto sm:px-6 lg:px-8" title="Submissions"
        description="Location: {{ $location->name }}">
        <x-slot name="svg">
            <x-svg.table-cells class="h-6 w-6 text-gray-500"/>
        </x-slot>

        {{-- Action buttons for editing the form and exporting data --}}
        <div class="flex items-center space-x-2">
            <a href="{{ route('locations.show', ['id' => $location->id]) }}" tooltip="Edit Form"
                class="inline-flex items-center px-2.5 py-1.5 space-x-1.5 border text-xs font-semibold uppercase tracking-widest rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 border-transparent text-white bg-blue-500 hover:bg-blue-700 focus:ring-blue-500 flex space-x-3 items-center">
                <x-svg.edit class="h-5 w-5"/>
            </a>

            <span class="flex items-center space-x-2 tour__submissions--2">
                <x-button btn="primary" wire:click="exportToExcel"
                    tooltip="Download your submission results as an Excel file.">
                    <x-svg.download class="h-5 w-5"/>
                    <span>Download .xls file</span>
                </x-button>
                <x-button btn="primary" wire:click="exportToCsv" tooltip="Download your submission results as a CSV file.">
                    <x-svg.download class="h-5 w-5"/>
                    <span>Download .csv file</span>
                </x-button>
            </span>
        </div>
    </x-page-header>

    {{-- Table for displaying submissions with filters --}}
    <div class="px-8 overflow-x-scroll pt-8">
        <x-table :collection="$submissions">
            {{-- Controls for pagination and filtering submissions --}}
            <x-slot:controls>
                <x-table.per-page/>

                <div class="md:col-span-3 col-span-6">
                    <x-input.date wire:model.live="dateFrom" label="Date From"/>
                </div>
                <div class="md:col-span-3 col-span-6">
                    <x-input.date wire:model.live="dateTo" label="Date To"/>
                </div>
                <div class="md:col-span-2 col-span-6">
                    <x-input.select wire:model.live="select" label="Search by">
                        <option value="">Select a column</option>
                        @foreach($headers as $header)
                            <option value="{{ $header }}">{{ $header }}</option>
                        @endforeach
                    </x-input.select>
                </div>
                <div class="md:col-span-3 col-span-6">
                    <x-input.text wire:model.live="search" label="Search" placeholder="Search..."/>
                </div>
            </x-slot:controls>

            {{-- Table header displaying column names --}}
            <x-slot:head>
                @foreach($headers as $header)
                    <th class="min-w-[9rem]">{{ $header }}</th>
                @endforeach
            </x-slot:head>

            {{-- Table body displaying submission data --}}
            @foreach($submissionsData as $submission)
                <tr>
                    @foreach($formComponents as $component)
                        <td>{{ $submission[$component->id] }}</td>
                    @endforeach
                    <td>{{ $submission['created_at'] }}</td> {{-- Display submission creation date --}}
                </tr>
            @endforeach

            {{-- Message displayed when there are no submissions --}}
            <x-slot:emptyStatement>
                <x-svg.info-circle class="inline-block h-5 w-5 text-gray-300 -mt-1 dark:text-gray-700"/>
                You do not have any Submissions.
            </x-slot:emptyStatement>
        </x-table>
    </div>
</div>
