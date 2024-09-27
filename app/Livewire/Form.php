<?php

    namespace App\Livewire;

    use App\Models\Location;
    use App\Models\Submission;
    use App\Models\SubmissionValue;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Illuminate\Validation\ValidationException;
    use Livewire\Component;

    class Form extends Component
    {
        public $location;

        public $layout;

        public $form = [];

        public $rules = [];

        public $validationAttributes = [];

        public $showQRCode;
        public $showClearForm = false;

        public function mount(Location $location, Request $request)
        {
            $this->location = $location;
            $this->loadLayout();
            $this->initializeForm();
            $isVisitor = $request->query('isVisitor', false);

            if(!$isVisitor) {
                $this->showQRCode = $this->location->settings()->get('enableVisitorDeviceSignIn', true);
            }
        }

        /**
         * Validation rules
         *
         * @return \string[][]
         */
        public function rules()
        {
            return $this->rules;
        }

        /**
         * Custom Validation Messages
         *
         * @var string[]
         */
        public function validationAttributes()
        {
            return $this->validationAttributes;
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
        }

        public function initializeForm()
        {
            // remove any layout items that are not inputs
            $layout = array_filter($this->layout, function ($layoutItem) {
                return ! in_array($layoutItem['layout'], ['divider', 'header', 'message']);
            });

            // Initialize the $form property based on the layout
            foreach ($layout as $layoutItem) {
                if ($layoutItem['layout'] === 'checkboxes') {
                    $options = [];
                    foreach($layoutItem['inputs']['options'] as $key => $option) {
                        $options[$key] = false;
                    }
                    $this->form[$layoutItem['id']] = ['type' => $layoutItem['layout'], 'value' => $options];
                } elseif ($layoutItem['layout'] === 'radio-buttons') {
                    $this->form[$layoutItem['id']] = ['type' => $layoutItem['layout'], 'value' => $layoutItem['inputs']['options'][0]];
                }else {
                    $this->form[$layoutItem['id']] = ['type' => $layoutItem['layout'], 'value' => ''];
                }
                $this->rules['form.' . $layoutItem['id'] . '.value'] = $this->setRulesArray($layoutItem);
                $this->setValidationAttributes($layoutItem);
            }
        }

        public function setRulesArray($layoutItem)
        {
            $rules = [];

            if ($layoutItem['layout'] === 'text') {
                $rules[] = 'string';
                $rules[] = 'max:255';
            }

            if ($layoutItem['layout'] === 'email') {
                $rules[] = 'email';
            }

            if ($layoutItem['layout'] === 'phone') {
                $rules[] = 'string';
            }

            if ($layoutItem['layout'] === 'number') {
                $rules[] = 'numeric';

                if ($layoutItem['inputs']['use-min']) {
                    $rules[] = 'min:'.$layoutItem['inputs']['min'];
                }
                if ($layoutItem['inputs']['use-max']) {
                    $rules[] = 'max:'.$layoutItem['inputs']['max'];
                }
            }

            if ($layoutItem['layout'] === 'paragraph') {
                $rules[] = 'string';
                $rules[] = 'max:1000';
            }

            if ($layoutItem['layout'] === 'drop-down' || $layoutItem['layout'] === 'radio-buttons') {
                $rules[] = 'string';
                $options = implode(',', $layoutItem['inputs']['options']);
                $rules[] = 'in:'.$options;
            }

            if ($layoutItem['layout'] === 'checkboxes'){
                $rules[] = 'array';
            }

            if ($layoutItem['layout'] === 'consent') {
                $rules[] = 'accepted';
            }

            if ($layoutItem['layout'] === 'date') {
                $rules[] = 'date';
            }

            if ($layoutItem['layout'] === 'time') {
                $rules[] = 'date_format:H:i';
            }

            if (isset($layoutItem['inputs']['required']) && $layoutItem['inputs']['required']) {
                $rules[] = 'required';
            }else{
                $rules[] = 'nullable';
            }

            return $rules;
        }

        public function setValidationAttributes(mixed $layoutItem)
        {
            // Set validationAttributes based on 'label' or 'message' with layout name
            if (isset($layoutItem['inputs']['label'])) {
                $this->validationAttributes['form.'.$layoutItem['id'].'.value'] = $layoutItem['inputs']['label'];
            } elseif (isset($layoutItem['inputs']['message'])) {
                $this->validationAttributes['form.'.$layoutItem['id'].'.value'] = $layoutItem['inputs']['message'];
            } else {
                // Handle the case when neither 'label' nor 'message' is present
                $this->validationAttributes['form.'.$layoutItem['id'].'.value'] = '';
            }
        }

        public function cancel()
        {
            $this->initializeForm();
            $this->showClearForm = false;
            flash('The form has been cleared.')->info()->livewire($this);
        }

        public function submit()
        {
            $this->validate();

            $submission = Submission::create([
                'location_id' => $this->location->id,
            ]);

            foreach ($this->form as $key => $value) {
                $object = [];
                $object['submission_id'] = $submission->id;
                $object['form_component_id'] = $key;
                if ($value['type'] === 'checkboxes') {
                    $object['json_value'] = json_encode($value['value']);
                }elseif ($value['type'] === 'paragraph') {
                    $object['large_value'] = $value['value'];
                }elseif ($value['type'] === 'consent') {
                    $object['boolean_value'] = $value['value'];
                }else{
                    $object['value'] = $value['value'];
                }
                SubmissionValue::create($object);
            }

            $this->initializeForm();

            flash('Your information was submitted!')->successOverlay()->livewire($this);
        }

        public function render()
        {
            return view('livewire.form');
        }
    }
