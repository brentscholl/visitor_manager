<?php

    namespace App\Livewire;

    use App\Models\Location;
    use App\Models\Submission;
    use App\Models\SubmissionValue;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Livewire\Component;

    /**
     * Component to display and manage a dynamic form for a location, including validation, submission, and optional QR code display.
     */
    class Form extends Component
    {
        /**
         * @var Location The location instance associated with this form.
         */
        public $location;

        /**
         * @var array The layout configuration for the form components.
         */
        public $layout;

        /**
         * @var array Holds the form data for each component.
         */
        public $form = [];

        /**
         * @var array Validation rules for each form component.
         */
        public $rules = [];

        /**
         * @var array Custom validation attribute names for the form components.
         */
        public $validationAttributes = [];

        /**
         * @var bool Indicates whether to show the QR code for visitor device sign-in.
         */
        public $showQRCode;

        /**
         * @var bool Controls the visibility of the clear form button.
         */
        public $showClearForm = false;

        /**
         * Initialize the component with the location data and form layout.
         *
         * @param Location $location The location instance.
         * @param Request $request The HTTP request instance.
         */
        public function mount(Location $location, Request $request)
        {
            $this->location = $location;
            $this->loadLayout();
            $this->initializeForm();

            $isVisitor = $request->query('isVisitor', false);
            $this->showQRCode = !$isVisitor && $this->location->settings()->get('enableVisitorDeviceSignIn', true);
        }

        /**
         * Define validation rules for the form components.
         *
         * @return array Validation rules for each component.
         */
        public function rules()
        {
            return $this->rules;
        }

        /**
         * Define custom validation attributes for form components.
         *
         * @return array Custom attribute names.
         */
        public function validationAttributes()
        {
            return $this->validationAttributes;
        }

        /**
         * Load the layout configuration for the form from the location's form components.
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
        }

        /**
         * Initialize the form data structure and set validation rules for each component.
         */
        public function initializeForm()
        {
            // Clear the form data
            $this->form = [];

            // Filter out non-input layout items
            $layout = array_filter($this->layout, function ($layoutItem) {
                return !in_array($layoutItem['layout'], ['divider', 'header', 'message']);
            });

            foreach ($layout as $layoutItem) {
                // Initialize each form component based on its type
                if ($layoutItem['layout'] === 'checkboxes') {
                    $options = array_fill_keys(array_keys($layoutItem['inputs']['options']), false);
                    $this->form[$layoutItem['id']] = ['type' => $layoutItem['layout'], 'value' => $options];
                } elseif ($layoutItem['layout'] === 'radio-buttons') {
                    $this->form[$layoutItem['id']] = ['type' => $layoutItem['layout'], 'value' => $layoutItem['inputs']['options'][0]];
                } else {
                    $this->form[$layoutItem['id']] = ['type' => $layoutItem['layout'], 'value' => ''];
                }

                // Set validation rules and attributes for each component
                $this->rules['form.' . $layoutItem['id'] . '.value'] = $this->setRulesArray($layoutItem);
                $this->setValidationAttributes($layoutItem);
            }
        }

        /**
         * Set the validation rules for a form component based on its layout type and attributes.
         *
         * @param array $layoutItem The layout configuration for the component.
         * @return array Validation rules for the component.
         */
        public function setRulesArray($layoutItem)
        {
            $rules = [];

            // Apply specific validation rules based on component type
            switch ($layoutItem['layout']) {
                case 'text':
                    $rules = ['string', 'max:255'];
                    break;
                case 'email':
                    $rules = ['email'];
                    break;
                case 'phone':
                    $rules = ['string'];
                    break;
                case 'number':
                    $rules = ['numeric'];
                    if ($layoutItem['inputs']['use-min']) {
                        $rules[] = 'min:' . $layoutItem['inputs']['min'];
                    }
                    if ($layoutItem['inputs']['use-max']) {
                        $rules[] = 'max:' . $layoutItem['inputs']['max'];
                    }
                    break;
                case 'paragraph':
                    $rules = ['string', 'max:1000'];
                    break;
                case 'drop-down':
                case 'radio-buttons':
                    $rules = ['string', 'in:' . implode(',', $layoutItem['inputs']['options'])];
                    break;
                case 'checkboxes':
                    $rules = ['array'];
                    break;
                case 'consent':
                    $rules = ['accepted'];
                    break;
                case 'date':
                    $rules = ['date'];
                    break;
                case 'time':
                    $rules = ['date_format:H:i'];
                    break;
            }

            // Apply 'required' or 'nullable' rule based on input requirements
            $rules[] = isset($layoutItem['inputs']['required']) && $layoutItem['inputs']['required'] ? 'required' : 'nullable';

            return $rules;
        }

        /**
         * Set custom validation attribute names for a form component.
         *
         * @param mixed $layoutItem The layout configuration for the component.
         */
        public function setValidationAttributes($layoutItem)
        {
            $label = $layoutItem['inputs']['label'] ?? $layoutItem['inputs']['message'] ?? '';
            $this->validationAttributes['form.' . $layoutItem['id'] . '.value'] = $label;
        }

        /**
         * Reset the form to its initial state.
         */
        public function cancel()
        {
            $this->initializeForm();
            $this->showClearForm = false;

            flash('The form has been cleared.')->info()->livewire($this);
        }

        /**
         * Handle form submission by validating and saving submission values.
         */
        public function submit()
        {
            $this->validate();

            // Create a new submission record for the location
            $submission = Submission::create(['location_id' => $this->location->id]);

            foreach ($this->form as $key => $value) {
                $object = [
                    'submission_id' => $submission->id,
                    'form_component_id' => $key,
                ];

                // Store the submission value based on component type
                switch ($value['type']) {
                    case 'checkboxes':
                        $object['json_value'] = json_encode($value['value']);
                        break;
                    case 'paragraph':
                        $object['large_value'] = $value['value'];
                        break;
                    case 'consent':
                        $object['boolean_value'] = $value['value'];
                        break;
                    default:
                        $object['value'] = $value['value'];
                        break;
                }

                // Create a new SubmissionValue record
                SubmissionValue::create($object);
            }

            // Reset the form to allow for new entries
            $this->initializeForm();

            flash('Your information was submitted!')->successOverlay()->livewire($this);
        }

        /**
         * Render the form view.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            return view('livewire.form');
        }
    }
