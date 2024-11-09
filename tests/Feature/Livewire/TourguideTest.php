<?php

    namespace Tests\Feature\Livewire;

    use App\Livewire\Tourguide;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Livewire\Livewire;
    use Tests\TestCase;

    /**
     * Test suite for the Tourguide Livewire component, which manages user onboarding tours.
     */
    class TourguideTest extends TestCase
    {
        use RefreshDatabase;

        /**
         * Set up each test by creating and authenticating a user.
         */
        protected function setUp(): void
        {
            parent::setUp();

            // Create and authenticate a user for testing
            $this->user = User::factory()->create();
            $this->actingAs($this->user);
        }

        /**
         * @test
         * Test that the welcome tour can be marked as finished.
         */
        public function it_marks_welcome_tour_as_finished()
        {
            // Initially set the welcome tour setting to true
            $this->user->settings()->set('tour_welcome', true);

            // Trigger the 'tourFinished' method on the Tourguide component
            Livewire::test(Tourguide::class)
                ->call('tourFinished', 'welcome');

            // Assert that the welcome tour setting is now false
            $this->assertFalse($this->user->settings()->get('tour_welcome'));
        }

        /**
         * @test
         * Test that the locations tour can be marked as finished.
         */
        public function it_marks_locations_tour_as_finished()
        {
            // Initially set the locations tour setting to true
            $this->user->settings()->set('tour_locations', true);

            // Trigger the 'tourFinished' method on the Tourguide component
            Livewire::test(Tourguide::class)
                ->call('tourFinished', 'locations');

            // Assert that the locations tour setting is now false
            $this->assertFalse($this->user->settings()->get('tour_locations'));
        }

        /**
         * @test
         * Test that the submissions tour can be marked as finished.
         */
        public function it_marks_submissions_tour_as_finished()
        {
            // Initially set the submissions tour setting to true
            $this->user->settings()->set('tour_submissions', true);

            // Trigger the 'tourFinished' method on the Tourguide component
            Livewire::test(Tourguide::class)
                ->call('tourFinished', 'submissions');

            // Assert that the submissions tour setting is now false
            $this->assertFalse($this->user->settings()->get('tour_submissions'));
        }

        /**
         * @test
         * Test that the welcome tour can be restarted.
         */
        public function it_restarts_welcome_tour()
        {
            // Initially set the welcome tour setting to false
            $this->user->settings()->set('tour_welcome', false);

            // Trigger the 'restartTour' method on the Tourguide component
            Livewire::test(Tourguide::class)
                ->call('restartTour', 'welcome');

            // Assert that the welcome tour setting is now true
            $this->assertTrue($this->user->settings()->get('tour_welcome'));
        }

        /**
         * @test
         * Test that the locations tour can be restarted.
         */
        public function it_restarts_locations_tour()
        {
            // Initially set the locations tour setting to false
            $this->user->settings()->set('tour_locations', false);

            // Trigger the 'restartTour' method on the Tourguide component
            Livewire::test(Tourguide::class)
                ->call('restartTour', 'locations');

            // Assert that the locations tour setting is now true
            $this->assertTrue($this->user->settings()->get('tour_locations'));
        }

        /**
         * @test
         * Test that the submissions tour can be restarted.
         */
        public function it_restarts_submissions_tour()
        {
            // Initially set the submissions tour setting to false
            $this->user->settings()->set('tour_submissions', false);

            // Trigger the 'restartTour' method on the Tourguide component
            Livewire::test(Tourguide::class)
                ->call('restartTour', 'submissions');

            // Assert that the submissions tour setting is now true
            $this->assertTrue($this->user->settings()->get('tour_submissions'));
        }
    }
