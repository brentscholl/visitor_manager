<?php

    namespace App\Livewire\Locations;

    use App\Models\FormComponent;
    use App\Models\Location;
    use App\Models\Submission;
    use App\Models\SubmissionValue;
    use Illuminate\Support\Str;
    use Livewire\Component;

    /**
     * Component to display and manage a list of locations.
     */
    class Index extends Component
    {
        /**
         * List of event listeners that trigger component updates.
         */
        protected $listeners = [
            'locationDeleted' => '$refresh',
            'locationCreated' => '$refresh',
            'locationUpdated' => '$refresh',
            'tourFinished'    => 'tourFinished',
        ];

        /**
         * Handles actions after the tour is finished.
         *
         * @param string $tour The name of the finished tour.
         */
        public function tourFinished($tour)
        {
            // Refresh the view after the tour is completed.
            $this->render();
        }

        /**
         * Dispatches an event to add a new location.
         */
        public function addLocation()
        {
            $this->dispatch('addLocation');
        }

        /**
         * Render the view with a list of locations.
         *
         * If the user has no locations and has enabled the welcome tour,
         * a default location setup is created for demonstration purposes.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            // Fetch all locations associated with the current team.
            $locations = Location::with('user')->where('team_id', auth()->user()->currentTeam->id)->get();

            // Check if the user has no locations and if the welcome tour is enabled.
            if ($locations->isEmpty() && auth()->user()->settings()->get('tour_welcome')) {
                // Prepare data for a demo location to guide new users.
                $data = [
                    'id'            => 0,
                    'name'          => 'My First Location',
                    'user_id'       => auth()->user()->id,
                    'team_id'       => auth()->user()->currentTeam->id,
                    'location_code' => generateLocationCode(),
                    'created_at'    => now(),
                ];

                // Create a demo location instance without persisting to the database.
                $location = Location::factory()->make($data);
                $location->fill($data);

                // Set up a default form component for the demo location.
                $formComponent = FormComponent::factory()->make([
                    'location_id' => $location->id,
                    'order'       => 1,
                    'type'        => 'text',
                    'inputs'      => [
                        'label'              => '',
                        'placeholder'        => '',
                        'required'           => '',
                        'show-optional-flag' => 0,
                    ],
                ]);

                // Create a demo submission for the location.
                $submission = Submission::factory()->make([
                    'location_id' => $location->id,
                ]);

                // Associate a submission value with the form component in the demo submission.
                SubmissionValue::factory()->make([
                    'submission_id'     => $submission->id,
                    'form_component_id' => $formComponent->id,
                    'value'             => '',
                ]);

                // Link the form component and submission to the demo location without saving to the database.
                $location->setRelation('formComponents', $formComponent);
                $location->setRelation('submissions', $submission);

                // Use the demo location for rendering.
                $locations = collect([$location]);
            }

            // Return the view with the list of locations.
            return view('livewire.locations.index', compact('locations'));
        }
    }
