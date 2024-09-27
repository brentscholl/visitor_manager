<?php

    namespace App\Livewire\Locations;

    use App\Models\FormComponent;
    use App\Models\Location;
    use App\Models\Submission;
    use App\Models\SubmissionValue;
    use App\Traits\HasMenu;
    use Illuminate\Support\Str;
    use Livewire\Component;

    class Index extends Component
    {
        protected $listeners = [
            'locationDeleted' => '$refresh',
            'locationCreated' => '$refresh',
            'locationUpdated' => '$refresh',
            'tourFinished'    => 'tourFinished',
        ];

        public function tourFinished($tour)
        {
            $this->render();
        }

        public function render()
        {
            $locations = Location::with('user')->where('team_id', auth()->user()->currentTeam->id)->get();
            if ($locations->isEmpty() && auth()->user()->settings()->get('tour_welcome')) {
                $data = [
                    'id'         => Str::uuid(),
                    'name'       => 'My First Location',
                    'user_id'    => auth()->user()->id,
                    'team_id'    => auth()->user()->currentTeam->id,
                    'created_at' => now(),
                ];
                $location = Location::factory()->make($data);
                $location->fill($data);

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

                $submission = Submission::factory()->make([
                    'location_id' => $location->id,
                ]);

                SubmissionValue::factory()->make([
                    'submission_id' => $submission->id,
                    'form_component_id' => $formComponent->id,
                    'value'         => '',
                ]);

                // Associate FormComponent and Submission with Location without saving
                $location->setRelation('formComponents', $formComponent);
                $location->setRelation('submissions', $submission);

                $locations = collect([$location]);
            }

            return view('livewire.locations.index', compact('locations'));
        }
    }
