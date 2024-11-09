<?php

    namespace App\Livewire\Locations;

    use App\Models\FormComponent;
    use App\Models\Location;
    use Illuminate\Support\Str;
    use Livewire\Component;

    /**
     * Component to handle the form builder interface for creating and managing sign-in forms for a location.
     */
    class FormBuilder extends Component
    {
        /**
         * @var Location The current location instance for which the form is being created.
         */
        public $location;

        /**
         * @var bool Control the visibility of the components selection modal.
         */
        public $showComponents = false;

        /**
         * @var bool Control the visibility of the connection modal.
         */
        public $showConnectModal = false;

        /**
         * @var bool Enable or disable visitor device sign-in via QR code.
         */
        public $enableVisitorDeviceSignIn = true;

        /**
         * @var bool Indicate if the form is in editing mode.
         */
        public $isEditing = false;

        /**
         * @var bool Track if changes have been made to the form layout.
         */
        public $changesMade = false;

        /**
         * @var bool Control the visibility of the delete component confirmation modal.
         */
        public $showDeleteComponentModal = false;

        /**
         * List of events the component listens to.
         */
        protected $listeners = [
            'tourFinished' => 'tourFinished',
        ];

        /**
         * @var array Stores the layout and structure of the form.
         */
        public $layout = [];

        /**
         * @var array Definition of available form components with their default properties.
         */
        public $components = [
            'text' => [
                'id' => null,
                'layout' => 'text',
                'inputs' => [
                    'label' => '',
                    'placeholder' => '',
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'email' => [
                'id' => null,
                'layout' => 'email',
                'inputs' => [
                    'label' => 'Email Address',
                    'placeholder' => '',
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'phone' => [
                'id' => null,
                'layout' => 'phone',
                'inputs' => [
                    'label' => 'Phone Number',
                    'placeholder' => '',
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'number' => [
                'id' => null,
                'layout' => 'number',
                'inputs' => [
                    'label' => '',
                    'use-min' => 0,
                    'min' => 0,
                    'use-max' => 0,
                    'max' => 0,
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'paragraph' => [
                'id' => null,
                'layout' => 'paragraph',
                'inputs' => [
                    'label' => '',
                    'placeholder' => '',
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'drop-down' => [
                'id' => null,
                'layout' => 'drop-down',
                'inputs' => [
                    'label' => '',
                    'options' => [
                        0 => '',
                    ],
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'checkboxes' => [
                'id' => null,
                'layout' => 'checkboxes',
                'inputs' => [
                    'label' => '',
                    'options' => [
                        0 => '',
                    ],
                    'required' => 0,
                    'show-optional-flag' => 0,
                    'inline' => 0,
                ],
            ],
            'radio-buttons' => [
                'id' => null,
                'layout' => 'radio-buttons',
                'inputs' => [
                    'label' => '',
                    'options' => [
                        0 => '',
                    ],
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'consent' => [
                'id' => null,
                'layout' => 'consent',
                'inputs' => [
                    'message' => '',
                ],
            ],
            'date' => [
                'id' => null,
                'layout' => 'date',
                'inputs' => [
                    'label' => '',
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'time' => [
                'id' => null,
                'layout' => 'time',
                'inputs' => [
                    'label' => '',
                    'required' => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'divider' => [
                'id' => null,
                'layout' => 'divider',
                'inputs' => [
                    'divide-label' => '',
                ],
            ],
            'header' => [
                'id' => null,
                'layout' => 'header',
                'inputs' => [
                    'content' => '',
                ],
            ],
            'message' => [
                'id' => null,
                'layout' => 'message',
                'inputs' => [
                    'message' => '',
                ],
            ],
        ];

        /**
         * Initialize the form builder with the specified location.
         *
         * @param Location $location The location for which the form is being built.
         */
        public function mount(Location $location)
        {
            $this->location = $location;

            // Load settings and layout for the location
            $this->enableVisitorDeviceSignIn = $this->location->settings()->get('enableVisitorDeviceSignIn', true);
            $this->loadLayout();

            // Setup a guided tour layout if enabled
            if (auth()->user()->settings()->get('tour_locations')) {
                $formComponent1 = FormComponent::factory()->make([
                    'location_id' => $this->location->id,
                    'order' => 1,
                    'type' => 'text',
                    'inputs' => json_encode([
                        'label' => 'Name',
                        'placeholder' => '',
                        'required' => '',
                        'show-optional-flag' => 0,
                    ]),
                ]);

                $formComponent2 = FormComponent::factory()->make([
                    'location_id' => $this->location->id,
                    'order' => 2,
                    'type' => 'paragraph',
                    'inputs' => json_encode([
                        'label' => 'Tell us about your visit',
                        'placeholder' => '',
                        'required' => '',
                        'show-optional-flag' => 0,
                    ]),
                ]);

                $this->location->setRelation('formComponents', collect([$formComponent1, $formComponent2]));
                $this->loadLayout();
            }
        }

        /**
         * Triggered when the guided tour is completed.
         */
        public function tourFinished()
        {
            $this->mount($this->location->refresh());
        }

        /**
         * Validation rules for the layout components.
         *
         * @return array Validation rules.
         */
        public function rules()
        {
            return [
                'layout.*.inputs.label' => ['sometimes', 'required', 'string', 'max:100'],
                'layout.*.inputs.divide-label' => ['sometimes', 'string', 'max:100'],
                'layout.*.inputs.placeholder' => ['sometimes', 'string', 'max:100'],
                'layout.*.inputs.options.*' => ['sometimes', 'required', 'string', 'max:200'],
                'layout.*.inputs.message' => ['sometimes', 'required', 'string', 'max:700'],
                'layout.*.inputs.content' => ['sometimes', 'required', 'string', 'max:200'],
            ];
        }

        /**
         * Custom validation attribute names.
         *
         * @return array Attribute names.
         */
        public function validationAttributes()
        {
            return [
                'layout.*.inputs.label' => 'label',
                'layout.*.inputs.divide-label' => 'divide label',
                'layout.*.inputs.placeholder' => 'placeholder',
                'layout.*.inputs.options.*' => 'option',
                'layout.*.inputs.message' => 'message',
                'layout.*.inputs.content' => 'content',
            ];
        }

        /**
         * Load the current layout for the location from the form components.
         */
        public function loadLayout()
        {
            $this->layout = $this->location->formComponents->map(function ($layout) {
                return [
                    'id' => $layout->id,
                    'layout' => $layout->type,
                    'inputs' => (array) json_decode($layout->inputs),
                ];
            })->toArray();

            $this->isEditing = !empty($this->layout);
        }

        /**
         * Toggle the enableVisitorDeviceSignIn setting and save it.
         */
        public function toggleEnableVisitorDeviceSignIn()
        {
            $this->location->settings()->set('enableVisitorDeviceSignIn', $this->enableVisitorDeviceSignIn);
        }

        /**
         * Set the changesMade flag to true when the layout is updated.
         */
        public function updated()
        {
            $this->changesMade = true;
        }

        /**
         * Add a new component to the layout.
         *
         * @param string $component The component type to add.
         */
        public function addComponent($component)
        {
            array_push($this->layout, $this->components[$component]);
            $this->showComponents = false;
        }

        /**
         * Remove a component from the layout.
         *
         * @param int $i The index of the component to remove.
         */
        public function removeComponent($i)
        {
            unset($this->layout[$i]);
            $this->layout = array_values($this->layout); // Reindex the array.
        }

        /**
         * Delete a component from the database and layout.
         *
         * @param int $i Index of the component in the layout.
         * @param int $id ID of the component in the database.
         */
        public function deleteComponent($i, $id)
        {
            unset($this->layout[$i]);
            $this->layout = array_values($this->layout); // Reindex array.

            FormComponent::find($id)->delete();

            $this->showDeleteComponentModal = false;

            flash('Form component deleted successfully!')->success()->livewire($this);
        }

        /**
         * Move a component within the layout based on the direction.
         *
         * @param string $direction Direction to move ('up' or 'down').
         * @param int $item Index of the item to move.
         */
        public function moveComponent($direction, $item)
        {
            $out = array_splice($this->layout, $item, 1);
            array_splice($this->layout, $direction === 'up' ? $item - 1 : $item + 1, 0, $out);
            $this->dispatch('layoutOrderChanged');
        }

        /**
         * Add a new option to the options array of a component.
         *
         * @param int $layoutIndex The index of the component in the layout.
         */
        public function addOption($layoutIndex)
        {
            array_push($this->layout[$layoutIndex]['inputs']['options'], null);
        }

        /**
         * Remove an option from a component.
         *
         * @param int $layoutIndex Index of the component in the layout.
         * @param int $optionIndex Index of the option to remove.
         */
        public function removeOption($layoutIndex, $optionIndex)
        {
            unset($this->layout[$layoutIndex]['inputs']['options'][$optionIndex]);
            $this->layout[$layoutIndex]['inputs']['options'] = array_values($this->layout[$layoutIndex]['inputs']['options']); // Reindex options.
        }

        /**
         * Create a form with the current layout.
         */
        public function createForm()
        {
            abort_unless(auth()->user()->currentTeam->id === $this->location->team_id, 403);

            $this->validate();

            foreach ($this->layout as $key => $component) {
                FormComponent::create([
                    'location_id' => $this->location->id,
                    'order' => $key,
                    'type' => $component['layout'],
                    'inputs' => json_encode($component['inputs']),
                ]);
            }

            flash('Form saved successfully!')->success()->livewire($this);

            return redirect()->route('locations.show', $this->location);
        }

        /**
         * Update the form with the current layout.
         */
        public function updateForm()
        {
            abort_unless(auth()->user()->currentTeam->id === $this->location->team_id, 403);

            $this->validate();

            foreach ($this->layout as $key => $component) {
                if ($component['id']) {
                    FormComponent::where('id', $component['id'])->update([
                        'order' => $key,
                        'inputs' => json_encode($component['inputs']),
                    ]);
                } else {
                    FormComponent::create([
                        'location_id' => $this->location->id,
                        'order' => $key,
                        'type' => $component['layout'],
                        'inputs' => json_encode($component['inputs']),
                    ]);
                }
            }

            flash('Form updated successfully!')->success()->livewire($this);
        }

        /**
         * Render the component view.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            return view('livewire.locations.form-builder');
        }
    }
