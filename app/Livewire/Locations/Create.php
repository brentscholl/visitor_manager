<?php

    namespace App\Livewire\Locations;

    use App\Models\Location;
    use Illuminate\Validation\Rule;
    use Livewire\Component;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Support\Str;

    /**
     * Component to handle the creation of Locations.
     */
    class Create extends Component
    {
        /**
         * @var bool Controls the visibility of the create modal.
         */
        public $showCreateModal = false;

        /**
         * @var string Name of the location being created.
         */
        public $name;

        /**
         * List of event listeners that trigger component updates.
         */
        protected $listeners = [
            'addLocation' => 'showCreateModalEvent',
        ];

        /**
         * Event method to set showCreateModal to true.
         */
        public function showCreateModalEvent()
        {
            $this->showCreateModal = true;
        }

        /**
         * Define validation rules for creating a location.
         *
         * @return array Validation rules for the name field.
         */
        protected function rules()
        {
            return [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('locations')->where(fn (Builder $query) =>
                    $query->where('team_id', auth()->user()->currentTeam->id)
                    ),
                ],
            ];
        }

        /**
         * Handle the creation of a new location.
         *
         * Validates the input, creates a new location, and resets the modal state.
         */
        public function createLocation()
        {
            // Validate input data
            $this->validate();

            // Create a new location with a unique UUID
            Location::create([
                'id' => Str::uuid()->toString(),
                'name' => $this->name,
                'team_id' => auth()->user()->currentTeam->id,
                'user_id' => auth()->user()->id,
                'location_code' => generateLocationCode(),
            ]);

            // Hide the modal and flash a success message
            $this->showCreateModal = false;
            flash('Location created successfully!')->success()->livewire($this);

            // Reset component state
            $this->reset();

            // Dispatch event to notify other components of the new location
            $this->dispatch('locationCreated');
        }

        /**
         * Handle changes to the visibility of the create modal.
         *
         * Resets component state when the modal is closed.
         *
         * @param bool $value The updated modal visibility state.
         */
        public function updatedShowCreateModal($value)
        {
            if (!$value) {
                // Reset component state if modal is closed
                $this->reset();
            }
        }

        /**
         * Render the Livewire component view.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            return view('livewire.locations.create');
        }
    }
