<?php

    namespace App\Exports;

    use Maatwebsite\Excel\Concerns\FromCollection;

    /**
     * Export class for submissions data, implementing the FromCollection concern for Excel export.
     */
    class SubmissionsExport implements FromCollection
    {
        /**
         * @var array The data to be exported.
         */
        protected $data;

        /**
         * Create a new instance of SubmissionsExport.
         *
         * @param array $data The data to be exported.
         */
        public function __construct($data)
        {
            $this->data = $data;
        }

        /**
         * Return the data as a collection for export.
         *
         * @return \Illuminate\Support\Collection The collection of data for export.
         */
        public function collection()
        {
            return collect($this->data);
        }

        /**
         * Get the headings for the export, assuming the first row contains headings.
         *
         * @return array The headings for the exported data.
         */
        public function headings(): array
        {
            return $this->data[0];
        }
    }
