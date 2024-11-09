<?php

    namespace Tests\Feature\Livewire\Locations;

    use App\Livewire\Locations\LocationRow;
    use App\Models\Location;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Validation\ValidationException;
    use Livewire\Livewire;
    use Tests\TestCase;

    /**
     * Test suite for the LocationRow Livewire component, which handles displaying
     * and managing actions for individual locations.
     */
    class LocationRowTest extends TestCase
    {
        use RefreshDatabase;

        protected $user;
        protected $location;

        /**
         * Set up each test by creating a user and associated location.
         */
        protected function setUp(): void
        {
            parent::setUp();

            // Create a user and log in
            $this->user = User::factory()->withPersonalTeam()->create();
            $this->actingAs($this->user);

            // Create a location associated with the user's current team
            $this->location = Location::factory()->create([
                'team_id' => $this->user->currentTeam->id,
                'user_id' => $this->user->id,
            ]);
        }

        /**
         * @test
         * Test that the LocationRow component renders correctly with the location's name.
         *
         * This ensures the component loads successfully and displays the location name.
         */
        public function component_renders_correctly()
        {
            Livewire::test(LocationRow::class, ['location' => $this->location])
                ->assertStatus(200)
                ->assertSee($this->location->name);
        }

        /**
         * @test
         * Test successful change of location name.
         *
         * This verifies that the location name can be changed, the modal closes,
         * and the 'locationUpdated' event is emitted.
         */
        public function change_location_name_successfully()
        {
            $newName = 'Updated Location Name';

            Livewire::test(LocationRow::class, ['location' => $this->location])
                ->set('name', $newName)
                ->call('changeLocationName')
                ->assertSet('renameLocation', false) // Check if the modal closed
                ->assertDispatched('locationUpdated'); // Check if the update event is emitted

            // Assert the location name was updated in the database
            $this->assertDatabaseHas('locations', [
                'id' => $this->location->id,
                'name' => $newName,
            ]);
        }

        /**
         * @test
         * Test that an empty name triggers a validation error.
         *
         * This ensures that a required validation error occurs when an
         * attempt is made to change the location name to an empty value.
         */
        public function change_location_name_validation_error()
        {
            Livewire::test(LocationRow::class, ['location' => $this->location])
                ->set('name', '') // Set an invalid (empty) name
                ->call('changeLocationName')
                ->assertHasErrors(['name' => 'required']); // Check for validation error
        }

        /**
         * @test
         * Test successful removal of a location.
         *
         * This verifies that the location is deleted, the 'locationDeleted' event is emitted,
         * and the location no longer exists in the database.
         */
        public function remove_location()
        {
            Livewire::test(LocationRow::class, ['location' => $this->location])
                ->call('removeLocation')
                ->assertDispatched('locationDeleted'); // Check if the delete event is emitted

            // Assert the location was removed from the database
            $this->assertDatabaseMissing('locations', [
                'id' => $this->location->id,
            ]);
        }

        /**
         * @test
         * Test displaying the rename modal for the location.
         *
         * This verifies that setting 'renameLocation' to true makes the modal visible.
         */
        public function show_rename_modal()
        {
            Livewire::test(LocationRow::class, ['location' => $this->location])
                ->set('renameLocation', true) // Simulate opening the rename modal
                ->assertSet('renameLocation', true); // Confirm modal is shown
        }

        /**
         * @test
         * Test displaying the delete confirmation modal.
         *
         * This ensures that setting 'deleteLocation' to true makes the delete confirmation modal visible.
         */
        public function show_delete_confirmation_modal()
        {
            Livewire::test(LocationRow::class, ['location' => $this->location])
                ->set('deleteLocation', true) // Simulate opening the delete modal
                ->assertSet('deleteLocation', true); // Confirm modal is shown
        }

        /**
         * @test
         * Test the 'hasLayout' flag is set when form components exist.
         *
         * This ensures the component recognizes that the location has an associated layout.
         */
        public function has_layout_flag_with_form_components()
        {
            // Add a form component to the location
            $this->location->formComponents()->create([
                'type' => 'text',
                'inputs' => json_encode(['label' => 'Sample Text']),
            ]);

            Livewire::test(LocationRow::class, ['location' => $this->location])
                ->assertSet('hasLayout', true);
        }

        /**
         * @test
         * Test the 'hasLayout' flag is set when submissions exist.
         *
         * This ensures the component recognizes that the location has associated submissions.
         */
        public function has_layout_flag_with_submissions()
        {
            // Add a submission to the location
            $this->location->submissions()->create();

            Livewire::test(LocationRow::class, ['location' => $this->location])
                ->assertSet('hasLayout', true);
        }
    }
