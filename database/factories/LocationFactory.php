<?php

    namespace Database\Factories;

    use App\Models\Team;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\Factory;
    use Illuminate\Support\Str;

    /**
     * Factory for generating fake data for the Location model.
     *
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
     */
    class LocationFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed> The attributes for a new Location instance.
         */
        public function definition(): array
        {
            return [
                'name' => $this->faker->company,
                'team_id' => Team::factory(),
                'user_id' => User::factory(),
                'location_code' => generateLocationCode(),
            ];
        }
    }
