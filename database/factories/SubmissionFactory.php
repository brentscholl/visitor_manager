<?php

    namespace Database\Factories;

    use App\Models\Location;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * Factory for generating fake data for the Submission model.
     *
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
     */
    class SubmissionFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed> The attributes for a new Submission instance.
         */
        public function definition(): array
        {
            return [
                'location_id' => Location::factory(),
            ];
        }
    }
