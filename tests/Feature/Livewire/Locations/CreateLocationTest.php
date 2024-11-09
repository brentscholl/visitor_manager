<?php

    namespace Tests\Feature\Livewire\Locations;

    use App\Livewire\Locations\Create;
    use App\Models\Location;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Str;
    use Livewire\Livewire;
    use Tests\TestCase;

    /**
     * Test suite for the Create Location Livewire component, which includes
     * tests for component rendering, data validation, and location creation logic.
     */
    class CreateLocationTest extends TestCase
    {
        use RefreshDatabase;

        /**
         * Set up each test by creating and authenticating a user with a personal team.
         */
        protected function setUp(): void
        {
            parent::setUp();

            // Create and authenticate a user for testing
            $this->user = User::factory()->withPersonalTeam()->create();
            $this->actingAs($this->user);
        }

        /**
         * @test
         * Test that the Create Location component can render successfully.
         */
        public function create_location_component_can_render()
        {
            // Render the component and assert the HTTP status code is 200
            Livewire::test(Create::class)
                ->assertStatus(200);
        }

        /**
         * @test
         * Test successful location creation with valid data.
         *
         * This verifies that a location can be created with valid data and that it is
         * associated correctly with the user's current team.
         */
        public function can_create_location_with_valid_data()
        {
            // Simulate setting a location name and calling the createLocation method
            Livewire::test(Create::class)
                ->set('name', 'New Location')
                ->call('createLocation')
                ->assertHasNoErrors();

            // Verify that the location is stored in the database with the correct team ID
            $this->assertDatabaseHas('locations', [
                'name' => 'New Location',
                'team_id' => $this->user->currentTeam->id,
            ]);
        }

        /**
         * @test
         * Test that a duplicate location name cannot be created within the same team.
         *
         * This ensures that the application enforces unique location names within a team.
         */
        public function cannot_create_duplicate_location_in_same_team()
        {
            // Create an initial location with a specific name
            Location::create([
                'id' => Str::uuid()->toString(),
                'name' => 'Duplicate Location',
                'team_id' => $this->user->currentTeam->id,
                'user_id' => $this->user->id,
                'location_code' => 'CODE123',
            ]);

            // Attempt to create another location with the same name in the same team
            Livewire::test(Create::class)
                ->set('name', 'Duplicate Location')
                ->call('createLocation')
                ->assertHasErrors(['name' => 'unique']);
        }

        /**
         * @test
         * Test that a location with the same name can be created in different teams.
         *
         * This verifies that locations with identical names are allowed across
         * different teams, ensuring unique validation only within the same team.
         */
        public function can_create_duplicate_location_name_in_different_teams()
        {
            // Set up a second user with their own team
            $user2 = User::factory()->withPersonalTeam()->create();

            // Create a location for the first user's team
            Location::create([
                'id' => Str::uuid()->toString(),
                'name' => 'Shared Location Name',
                'team_id' => $this->user->currentTeam->id,
                'user_id' => $this->user->id,
                'location_code' => 'CODE123',
            ]);

            // Log in as the second user and attempt to create a location with the same name
            $this->actingAs($user2);

            Livewire::test(Create::class)
                ->set('name', 'Shared Location Name')
                ->call('createLocation')
                ->assertHasNoErrors();

            // Verify that the new location is saved under the second user's team
            $this->assertDatabaseHas('locations', [
                'name' => 'Shared Location Name',
                'team_id' => $user2->currentTeam->id,
            ]);
        }

        /**
         * @test
         * Test that the location name is required.
         *
         * This verifies that the application enforces the presence of a name when creating a location.
         */
        public function name_is_required()
        {
            // Attempt to create a location without a name
            Livewire::test(Create::class)
                ->set('name', '')
                ->call('createLocation')
                ->assertHasErrors(['name' => 'required']);
        }

        /**
         * @test
         * Test that the location name does not exceed the maximum length constraint.
         *
         * This ensures a validation error is triggered if the name exceeds 255 characters.
         */
        public function name_must_not_exceed_maximum_length()
        {
            // Create a name that exceeds the maximum length of 255 characters
            $longName = str_repeat('a', 256);

            Livewire::test(Create::class)
                ->set('name', $longName)
                ->call('createLocation')
                ->assertHasErrors(['name' => 'max']);
        }
    }
