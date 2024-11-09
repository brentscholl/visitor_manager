<?php

    namespace Tests\Feature\Livewire\Locations;

    use App\Livewire\Locations\Index;
    use App\Models\FormComponent;
    use App\Models\Location;
    use App\Models\Submission;
    use App\Models\SubmissionValue;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Livewire\Livewire;
    use Tests\TestCase;

    /**
     * Test suite for the Index Livewire component, which displays and manages
     * the list of locations for a user's team.
     */
    class IndexTest extends TestCase
    {
        use RefreshDatabase;

        protected $user;

        /**
         * Set up each test by creating and authenticating a user.
         */
        protected function setUp(): void
        {
            parent::setUp();

            // Create and authenticate a user with a personal team
            $this->user = User::factory()->withPersonalTeam()->create();
            $this->actingAs($this->user);

            // Disable welcome tour by default
            $this->user->settings()->update('tour_welcome', false);
        }

        /**
         * @test
         * Ensure the component renders with locations associated with the user's team.
         *
         * This verifies that multiple locations appear on the Index component
         * and that they are passed correctly to the view.
         */
        public function component_renders_with_locations()
        {
            // Create locations associated with the user's current team
            $location1 = Location::factory()->create(['team_id' => $this->user->currentTeam->id, 'user_id' => $this->user->id]);
            $location2 = Location::factory()->create(['team_id' => $this->user->currentTeam->id, 'user_id' => $this->user->id]);

            Livewire::test(Index::class)
                ->assertSee($location1->name)
                ->assertSee($location2->name)
                ->assertViewHas('locations', function ($locations) use ($location1, $location2) {
                    return $locations->contains($location1) && $locations->contains($location2);
                });
        }

        /**
         * @test
         * Verify that a demo location is created when there are no locations, and the welcome tour is enabled.
         *
         * This checks that a default location named "My First Location" is automatically
         * created if the welcome tour is enabled and the user has no locations.
         */
        public function demo_location_is_created_when_no_locations_and_welcome_tour_enabled()
        {
            // Enable the welcome tour
            $this->user->settings()->update('tour_welcome', true);

            // Assert no locations exist initially
            $this->assertEmpty(Location::where('team_id', $this->user->currentTeam->id)->get());

            // Test rendering with demo location
            Livewire::test(Index::class)
                ->assertSee('My First Location')
                ->assertViewHas('locations', function ($locations) {
                    $location = $locations->first();

                    return $location->name === 'My First Location' &&
                        (string) $location->user_id === (string) $this->user->id &&
                        (string) $location->team_id === (string) $this->user->currentTeam->id;
                });
        }

        /**
         * @test
         * Verify that the demo location includes a form component and submission when the welcome tour is enabled.
         *
         * This ensures that the demo location created by enabling the welcome tour
         * contains an initial form component and a sample submission.
         */
        public function demo_location_includes_form_component_and_submission()
        {
            // Enable the welcome tour and test demo location contents
            $this->user->settings()->update('tour_welcome', true);

            Livewire::test(Index::class)
                ->assertViewHas('locations', function ($locations) {
                    $location = $locations->first();
                    $formComponent = $location->formComponents;
                    $submission = $location->submissions;

                    return $formComponent && $submission &&
                        $formComponent->type === 'text' &&
                        (string) $submission->location_id === (string) $location->id;
                });
        }
    }
