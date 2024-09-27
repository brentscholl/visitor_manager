<?php

    namespace App\Livewire\Locations;

    use App\Models\FormComponent;
    use App\Models\Location;
    use App\Models\Submission;
    use App\Models\SubmissionValue;
    use Illuminate\Support\Str;
    use Livewire\Component;

    class FormBuilder extends Component
    {
        public $location;

        public $showComponents = false;
        public $showConnectModal = false;

        public $enableVisitorDeviceSignIn = true;

        public $isEditing = false;

        public $changesMade = false;

        public $showDeleteComponentModal = false;

        protected $listeners = [
            'tourFinished'    => 'tourFinished',
        ];

        public $layout = [];

        public $components = [
            'text'          => [
                'id'     => null,
                'layout' => 'text',
                'inputs' => [
                    'label'              => '',
                    'placeholder'        => '',
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'email'         => [
                'id'     => null,
                'layout' => 'email',
                'inputs' => [
                    'label'              => 'Email Address',
                    'placeholder'        => '',
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'phone'         => [
                'id'     => null,
                'layout' => 'phone',
                'inputs' => [
                    'label'              => 'Phone Number',
                    'placeholder'        => '',
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'number'        => [
                'id'     => null,
                'layout' => 'number',
                'inputs' => [
                    'label'              => '',
                    'use-min'            => 0,
                    'min'                => 0,
                    'use-max'            => 0,
                    'max'                => 0,
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'paragraph'     => [
                'id'     => null,
                'layout' => 'paragraph',
                'inputs' => [
                    'label'              => '',
                    'placeholder'        => '',
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'drop-down'     => [
                'id'     => null,
                'layout' => 'drop-down',
                'inputs' => [
                    'label'              => '',
                    'options'            => [
                        0 => '',
                    ],
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'checkboxes'    => [
                'id'     => null,
                'layout' => 'checkboxes',
                'inputs' => [
                    'label'              => '',
                    'options'            => [
                        0 => '',
                    ],
                    'required'           => 0,
                    'show-optional-flag' => 0,
                    'inline'             => 0,
                ],
            ],
            'radio-buttons' => [
                'id'     => null,
                'layout' => 'radio-buttons',
                'inputs' => [
                    'label'              => '',
                    'options'            => [
                        0 => '',
                    ],
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'consent'       => [
                'id'     => null,
                'layout' => 'consent',
                'inputs' => [
                    'message' => '',
                ],
            ],
            'date'          => [
                'id'     => null,
                'layout' => 'date',
                'inputs' => [
                    'label'              => '',
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'time'          => [
                'id'     => null,
                'layout' => 'time',
                'inputs' => [
                    'label'              => '',
                    'required'           => 0,
                    'show-optional-flag' => 0,
                ],
            ],
            'divider'       => [
                'id'     => null,
                'layout' => 'divider',
                'inputs' => [
                    'divide-label' => '',
                ],
            ],

            'header' => [
                'id'     => null,
                'layout' => 'header',
                'inputs' => [
                    'content' => '',
                ],
            ],

            'message' => [
                'id'     => null,
                'layout' => 'message',
                'inputs' => [
                    'message' => '',
                ],
            ],
        ];

        public function mount(Location $location)
        {
            $this->location = $location;

            $this->enableVisitorDeviceSignIn = $this->location->settings()->get('enableVisitorDeviceSignIn', true);

            $this->loadLayout();

            if (auth()->user()->settings()->get('tour_locations')) {

                $formComponent1 = FormComponent::factory()->make([
                    'location_id' => $this->location->id,
                    'order'       => 1,
                    'type'        => 'text',
                    'inputs'      => json_encode([
                        'label'              => 'Name',
                        'placeholder'        => '',
                        'required'           => '',
                        'show-optional-flag' => 0,
                    ]),
                ]);
                $formComponent2 = FormComponent::factory()->make([
                    'location_id' => $this->location->id,
                    'order'       => 2,
                    'type'        => 'paragraph',
                    'inputs'      => json_encode([
                        'label'              => 'Tell us about your visit',
                        'placeholder'        => '',
                        'required'           => '',
                        'show-optional-flag' => 0,
                    ]),
                ]);
                $formComponents = collect([$formComponent1, $formComponent2]);

                // Associate FormComponent and Submission with Location without saving
                $this->location->setRelation('formComponents', $formComponents);
                $this->loadLayout();
            }
            //$this->addComponent('text', 0);
            //$this->addComponent('email', 1);
            //$this->addComponent('phone', 2);
            //$this->addComponent('number', 3);
            //$this->addComponent('paragraph', 4);
            //$this->addComponent('drop-down', 5);
            //$this->addComponent('checkboxes', 6);
            //$this->addComponent('radio-buttons', 7);
            //$this->addComponent('consent', 8);
            //$this->addComponent('date', 9);
            //$this->addComponent('time', 10);
            //$this->addComponent('divider', 11);
            //$this->addComponent('header', 12);
            //$this->addComponent('message', 13);
        }

        public function tourFinished()
        {
            $this->mount($this->location->refresh());
        }

        /**
         * Validation rules
         *
         * @return \string[][]
         */
        public function rules()
        {
            return [
                'layout.*.inputs.label'        => ['sometimes', 'required', 'string', 'max:100'],
                'layout.*.inputs.divide-label' => ['sometimes', 'string', 'max:100'],
                'layout.*.inputs.placeholder'  => ['sometimes', 'string', 'max:100'],
                'layout.*.inputs.options.*'    => ['sometimes', 'required', 'string', 'max:200'],
                'layout.*.inputs.message'      => ['sometimes', 'required', 'string', 'max:700'],
                'layout.*.inputs.content'      => ['sometimes', 'required', 'string', 'max:200'],
            ];
        }

        /**
         * Custom Validation Messages
         *
         * @var string[]
         */
        public function validationAttributes()
        {
            return [
                'layout.*.inputs.label'        => 'label',
                'layout.*.inputs.divide-label' => 'label',
                'layout.*.inputs.placeholder'  => 'placeholder',
                'layout.*.inputs.options.*'    => 'option',
                'layout.*.inputs.message'      => 'message',
                'layout.*.inputs.content'      => 'content',
            ];
        }

        public function loadLayout()
        {
            $this->layout = $this->location->formComponents->map(function ($layout) {
                return [
                    'id'     => $layout->id,
                    'layout' => $layout->type,
                    'inputs' => (array) json_decode($layout->inputs),
                ];
            })->toArray();

            if ($this->layout) {
                $this->isEditing = true;
            }
        }

        public function toggleEnableVisitorDeviceSignIn()
        {
            $this->location->settings()->set('enableVisitorDeviceSignIn', $this->enableVisitorDeviceSignIn);
        }

        public function updated()
        {
            $this->changesMade = true;
        }

        /**
         * Add component to layout and load its data
         *
         * @param $component
         * @param $i
         */
        public function addComponent($component)
        {
            array_push($this->layout, $this->components[$component]);
            $this->showComponents = false;
        }

        /**
         * Remove component from layout
         *
         * @param $i
         */
        public function removeComponent($i)
        {
            unset($this->layout[$i]);
            $this->layout = array_values($this->layout); // reindex array
        }

        /**
         * Remove component from layout
         *
         * @param $i
         */
        public function deleteComponent($i, $id)
        {
            unset($this->layout[$i]);
            $this->layout = array_values($this->layout); // reindex array

            FormComponent::find($id)->delete();

            $this->showDeleteComponentModal = false;

            flash('Form component deleted successfully!')->success()->livewire($this);
        }

        /**
         * Change the order of the layout components
         * (on move button click)
         *
         * @param $list
         */
        public function moveComponent($direction, $item)
        {
            $out = array_splice($this->layout, $item, 1);
            array_splice($this->layout, $direction == 'up' ? $item - 1 : $item + 1, 0, $out);
            $this->dispatch('layoutOrderChanged');
        }

        /**
         * Add new url when add new url button is clicked
         */
        public function addOption($layoutIndex)
        {
            array_push($this->layout[$layoutIndex]['inputs']['options'], null);
        }

        /**
         * Remove url when remove button is clicked
         *
         * @param $i
         */
        public function removeOption($layoutIndex, $optionIndex)
        {
            unset($this->layout[$layoutIndex]['inputs']['options'][$optionIndex]);
            // Rebuild Collections
            $this->layout[$layoutIndex]['inputs']['options'] = array_values($this->layout[$layoutIndex]['inputs']['options']);
        }

        public function createForm()
        {
            abort_unless(auth()->user()->currentTeam->id === $this->location->team_id, 403);

            $this->validate();

            foreach ($this->layout as $key => $component) {
                FormComponent::create([
                    'location_id' => $this->location->id,
                    'order'       => $key,
                    'type'        => $component['layout'],
                    'inputs'      => json_encode($component['inputs']),
                ]);
            }

            flash('Form saved successfully!')->success()->livewire($this);

            return redirect()->route('locations.show', $this->location);

        }

        public function updateForm()
        {
            abort_unless(auth()->user()->currentTeam->id === $this->location->team_id, 403);

            $this->validate();

            foreach ($this->layout as $key => $component) {
                if ($component['id']) {
                    FormComponent::where('id', $component['id'])->update([
                        'order'  => $key,
                        'inputs' => json_encode($component['inputs']),
                    ]);
                } else {
                    FormComponent::create([
                        'location_id' => $this->location->id,
                        'order'       => $key,
                        'type'        => $component['layout'],
                        'inputs'      => json_encode($component['inputs']),
                    ]);
                }
            }

            flash('Form updated successfully!')->success()->livewire($this);
        }

        public function render()
        {
            return view('livewire.locations.form-builder');
        }
    }
