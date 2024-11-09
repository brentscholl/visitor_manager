<?php

    namespace Database\Factories;

    use App\Models\Team;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * Factory for generating fake data for the Team model.
     *
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
     */
    class TeamFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed> The attributes for a new Team instance.
         */
        public function definition(): array
        {
            return [
                'name' => $this->faker->unique()->company(),
                'user_id' => User::factory(),
                'personal_team' => true,
            ];
        }
    }
