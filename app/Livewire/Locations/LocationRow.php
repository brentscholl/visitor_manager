<?php

    namespace App\Livewire\Locations;

    use App\Models\Location;
    use App\Traits\HasMenu;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Validation\Rule;
    use Livewire\Component;

    /**
     * Component to manage and display a single row for a location.
     */
    class LocationRow extends Component
    {
        use HasMenu;

        /**
         * @var Location The location instance for this row.
         */
        public $location;

        /**
         * @var bool Flag to control the delete confirmation modal.
         */
        public $deleteLocation = false;

        /**
         * @var bool Flag to control the rename form visibility.
         */
        public $renameLocation = false;

        /**
         * @var string The name of the location, used for editing.
         */
        public $name;

        /**
         * @var bool Flag to control the visibility of the connection modal.
         */
        public $showConnectModal = false;

        /**
         * @var bool Indicates whether the location has a layout or submissions.
         */
        public $hasLayout = false;

        /**
         * Define validation rules for renaming the location.
         *
         * @return array Validation rules for location name.
         */
        public function rules()
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
         * Initialize the component with the given location.
         *
         * @param Location $location The location instance.
         */
        public function mount(Location $location)
        {
            $this->location = $location;
            $this->name = $this->location->name;

            // Determine if the location has a layout based on form components or submissions.
            if ($this->location->formComponents && auth()->user()->settings()->get('tour_welcome')) {
                $this->hasLayout = true;
            } else {
                $this->hasLayout = $this->location->formComponents()->count() > 0 || $this->location->submissions()->count() > 0;
            }
        }

        /**
         * Change the name of the location.
         *
         * Validates and updates the location name, then refreshes the display.
         */
        public function changeLocationName()
        {
            // Ensure the user has permission to modify the location.
            abort_unless($this->location->team_id === auth()->user()->currentTeam->id, 403);

            // Validate the new name.
            $this->validate();

            // Update the location's name.
            $this->location->update([
                'name' => $this->name,
            ]);

            // Reflect the updated name and close the rename form.
            $this->name = $this->location->name;
            $this->renameLocation = false;

            // Show a success message.
            flash('Location renamed successfully!')->success()->livewire($this);

            // Dispatch an event to notify other components of the update.
            $this->dispatch('locationUpdated');
        }

        /**
         * Remove the location from the database.
         *
         * Deletes the location and dispatches an event to refresh the display.
         */
        public function removeLocation()
        {
            // Ensure the user has permission to delete the location.
            abort_unless($this->location->team_id === auth()->user()->currentTeam->id, 403);

            // Delete the location.
            $this->location->delete();

            // Show a success message.
            flash('Location deleted successfully!')->success()->livewire($this);

            // Dispatch an event to notify other components of the deletion.
            $this->dispatch('locationDeleted');
        }

        /**
         * Render the view for this location row.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            return view('livewire.locations.location-row');
        }
    }
