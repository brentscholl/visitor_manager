<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class SubmissionsExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        // Assuming the first row contains headings
        return $this->data[0];
    }
}
