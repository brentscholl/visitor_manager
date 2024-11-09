<?php

    namespace Database\Factories;

    use App\Models\FormComponent;
    use App\Models\Submission;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * Factory for generating fake data for the SubmissionValue model.
     *
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubmissionValue>
     */
    class SubmissionValueFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed> The attributes for a new SubmissionValue instance.
         */
        public function definition(): array
        {
            return [
                'submission_id' => Submission::factory(),
                'form_component_id' => FormComponent::factory(),
                'value' => '',
            ];
        }
    }
