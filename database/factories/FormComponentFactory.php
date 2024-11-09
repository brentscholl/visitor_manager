<?php

    namespace Database\Factories;

    use App\Models\Location;
    use App\Models\FormComponent;
    use Illuminate\Database\Eloquent\Factories\Factory;
    use Illuminate\Support\Str;

    /**
     * Factory for generating fake data for FormComponent model.
     */
    class FormComponentFactory extends Factory
    {
        /**
         * The name of the model associated with this factory.
         *
         * @var string
         */
        protected $model = FormComponent::class;

        /**
         * Define the model's default state.
         *
         * @return array<string, mixed> The attributes for a new FormComponent instance.
         */
        public function definition(): array
        {
            $type = $this->faker->randomElement([
                'text',
                'email',
                'phone',
                'number',
                'paragraph',
                'drop-down',
                'checkboxes',
                'radio-buttons',
                'consent',
                'date',
                'time',
                'divider',
                'header',
                'message',
            ]);

            return [
                'location_id' => Location::factory(),
                'order' => $this->faker->numberBetween(1, 10),
                'type' => $type,
                'inputs' => json_encode($this->getInputsForType($type)),
            ];
        }

        /**
         * Generate input configurations based on the component type.
         *
         * @param string $type The type of form component.
         * @return array<string, mixed> The input attributes based on the type.
         */
        protected function getInputsForType($type): array
        {
            switch ($type) {
                case 'text':
                    return [
                        'label' => $this->faker->sentence,
                        'placeholder' => $this->faker->sentence,
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'email':
                    return [
                        'label' => 'Email Address',
                        'placeholder' => '',
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'phone':
                    return [
                        'label' => 'Phone Number',
                        'placeholder' => '',
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'number':
                    return [
                        'label' => $this->faker->sentence,
                        'use-min' => $this->faker->boolean,
                        'min' => $this->faker->numberBetween(1, 100),
                        'use-max' => $this->faker->boolean,
                        'max' => $this->faker->numberBetween(101, 200),
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'paragraph':
                    return [
                        'label' => $this->faker->sentence,
                        'placeholder' => $this->faker->sentence,
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'drop-down':
                    return [
                        'label' => $this->faker->sentence,
                        'options' => [$this->faker->word, $this->faker->word, $this->faker->word],
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'checkboxes':
                    return [
                        'label' => $this->faker->sentence,
                        'options' => [$this->faker->word, $this->faker->word, $this->faker->word],
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                        'inline' => $this->faker->boolean,
                    ];
                case 'radio-buttons':
                    return [
                        'label' => $this->faker->sentence,
                        'options' => [$this->faker->word, $this->faker->word, $this->faker->word],
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'consent':
                    return [
                        'message' => $this->faker->sentence,
                    ];
                case 'date':
                    return [
                        'label' => $this->faker->sentence,
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'time':
                    return [
                        'label' => $this->faker->sentence,
                        'required' => $this->faker->boolean,
                        'show-optional-flag' => 0,
                    ];
                case 'divider':
                    return [
                        'divide-label' => $this->faker->sentence,
                    ];
                case 'header':
                    return [
                        'content' => $this->faker->sentence,
                    ];
                case 'message':
                    return [
                        'message' => $this->faker->sentence,
                    ];
                default:
                    return [];
            }
        }
    }
