<?php

    namespace Tests\Feature\Livewire;

    use App\Models\Location;
    use App\Models\Submission;
    use App\Models\SubmissionValue;
    use App\Livewire\Form;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Livewire\Livewire;
    use Tests\TestCase;

    /**
     * Test suite for the Form Livewire component.
     */
    class FormTest extends TestCase
    {
        use RefreshDatabase;

        /**
         * Reset any Livewire or global state after each test.
         */
        protected function tearDown(): void
        {
            parent::tearDown();
            Livewire::flushState();
        }

        /**
         * @test
         * Test if the form component renders with the expected layout and displays the QR code instructions.
         */
        public function form_component_renders_correctly_with_layout_and_qr_code()
        {
            // Create a sample location for the form
            $location = Location::factory()->create();

            // Render the form component and assert expected text and state
            Livewire::test(Form::class, ['location' => $location])
                ->assertSee('To complete the form using your personal device, please scan the QR code displayed above.')
                ->assertSet('location', $location);
        }

        /**
         * @test
         * Test that the form component submits data successfully and stores it in the database.
         */
        public function form_component_submits_data_successfully()
        {
            // Create a location and define mock form components (e.g., text and consent)
            $location = Location::factory()->create();
            $location->formComponents()->createMany([
                [
                    'type' => 'text',
                    'inputs' => json_encode(['label' => 'Full Name', 'required' => true]),
                ],
                [
                    'type' => 'consent',
                    'inputs' => json_encode(['message' => 'I agree to terms', 'required' => true]),
                ],
            ]);

            // Test form submission with valid input data
            Livewire::test(Form::class, ['location' => $location])
                ->set('form.1.value', 'John Doe')       // Set Full Name field
                ->set('form.2.value', true)             // Set Consent checkbox
                ->call('submit')                        // Submit the form
                ->assertHasNoErrors();                  // Ensure no validation errors

            // Verify that the data is stored in the database
            $this->assertDatabaseHas('submissions', ['location_id' => $location->id]);
            $this->assertDatabaseHas('submission_values', ['value' => 'John Doe']);
            $this->assertDatabaseHas('submission_values', ['boolean_value' => true]);
        }

        /**
         * @test
         * Test if the form can be cleared after filling in values, resetting to initial state.
         */
        public function form_can_be_cleared_after_filling()
        {
            // Create a location and add a text field form component
            $location = Location::factory()->create();
            $location->formComponents()->create([
                'type' => 'text',
                'inputs' => json_encode(['label' => 'Full Name']),
            ]);

            // Test clearing the form by setting a value and then calling the cancel method
            Livewire::test(Form::class, ['location' => $location])
                ->set('form.1.value', 'John Doe')      // Set an initial value
                ->call('cancel')                       // Clear the form
                ->assertSet('form.1.value', '');       // Verify that the form value is reset
        }
    }
