<?php

    namespace App\Traits;

    use Livewire\WithPagination;

    /**
     * Trait to add table sorting, searching, and pagination functionality.
     */
    trait Tableable
    {
        use WithPagination;

        /**
         * @var int The number of items to display per page.
         */
        public $perPage = 20;

        /**
         * @var string The field by which to sort the table data.
         */
        public $sortField = '';

        /**
         * @var bool Determines the sort order; true for ascending, false for descending.
         */
        public $sortAsc = true;

        /**
         * @var string The search query for filtering table data.
         */
        public $search = '';

        /**
         * Update the sorting field. If the field is the same as the current sort field, toggle the sort order.
         *
         * @param string $field The field to sort by.
         * @return void
         */
        public function sortBy($field)
        {
            // Set sort to ascending by default, or toggle if the same field is clicked again
            $this->sortAsc = ($this->sortField === $field) ? !$this->sortAsc : true;
            $this->sortField = $field;
        }
    }
