<?php

namespace App\Traits;

use Livewire\WithPagination;

trait Tableable
{
    use WithPagination;
    public $perPage = 20;

    public $sortField = '';

    public $sortAsc = true;

    public $search = '';

    /**
     * Update the sort by field. If field is the same, inverse the sort by order.
     *
     * @param $field
     * @return void
     */
    public function sortBy($field)
    {
        $this->sortAsc = true;

        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        }

        $this->sortField = $field;
    }
}
