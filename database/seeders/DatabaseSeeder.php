<?php

    namespace Database\Seeders;

    use App\Models\FormComponent;
    use App\Models\Location;
    use App\Models\User;
    use Illuminate\Container\Container;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;
    use Faker\Generator;

    /**
     * Main database seeder class to populate the database with initial data.
     */
    class DatabaseSeeder extends Seeder
    {
        /**
         * The current Faker instance.
         *
         * @var \Faker\Generator
         */
        protected $faker;

        /**
         * Initialize a new DatabaseSeeder instance and load a Faker instance.
         */
        public function __construct()
        {
            $this->faker = $this->withFaker();
        }

        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run(): void
        {
            // Create a user with a personal team and a specified email and name
            $user = User::factory()->withPersonalTeam()->create([
                'name' => 'John Doe',
                'email' => 'bscholl@parcelytics.com',
            ]);

            // Create a location for the user and seed its form components
            Location::factory()->create([
                'name' => 'Store',
                'user_id' => $user->id,
                'team_id' => $user->currentTeam->id,
            ])->each(function ($location) {
                $this->seedFormComponents($location);
            });
        }

        /**
         * Seed form components for a location, creating one of each type.
         *
         * @param  \App\Models\Location  $location
         * @return void
         */
        protected function seedFormComponents(Location $location)
        {
            $formLayoutTypes = [
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
            ];

            $i = 0;
            foreach ($formLayoutTypes as $type) {
                FormComponent::factory()->create([
                    'order' => $i,
                    'location_id' => $location->id,
                    'type' => $type,
                    'inputs' => json_encode($this->getInputsForType($type)),
                ]);
                $i++;
            }
        }

        /**
         * Generate input attributes based on the form component type.
         *
         * @param string $type The type of form component.
         * @return array<string, mixed> The generated input attributes.
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

        /**
         * Get a new Faker instance.
         *
         * @return \Faker\Generator The Faker instance.
         */
        protected function withFaker()
        {
            return Container::getInstance()->make(Generator::class);
        }
    }
