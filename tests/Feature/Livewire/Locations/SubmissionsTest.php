<?php

    namespace Tests\Feature\Livewire\Locations;

    use App\Livewire\Locations\Submissions;
    use App\Models\FormComponent;
    use App\Models\Location;
    use App\Models\Submission;
    use App\Models\SubmissionValue;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Livewire\Livewire;
    use Tests\TestCase;

    /**
     * Test suite for the Submissions Livewire component, which manages and filters
     * submissions for a specific location.
     */
    class SubmissionsTest extends TestCase
    {
        use RefreshDatabase;

        protected $user;
        protected $location;
        protected $formComponent;

        /**
         * Set up each test by creating a user, location, and form components with submissions.
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

            // Create a form component for the location
            $this->formComponent = FormComponent::factory()->create([
                'location_id' => $this->location->id,
                'type' => 'text',
                'inputs' => json_encode(['label' => 'Sample Text Label']),
            ]);

            // Create sample submissions with values for testing
            Submission::factory()->count(3)->create(['location_id' => $this->location->id])->each(function ($submission) {
                SubmissionValue::factory()->create([
                    'submission_id' => $submission->id,
                    'form_component_id' => $this->formComponent->id,
                    'value' => 'Sample Value',
                ]);
            });
        }

        /**
         * @test
         * Test that the Submissions component renders correctly.
         *
         * This verifies the component can be loaded successfully and shows
         * the location's name on the screen.
         */
        public function component_renders_correctly()
        {
            Livewire::test(Submissions::class, ['location' => $this->location])
                ->assertStatus(200)
                ->assertSee($this->location->name);
        }

        /**
         * @test
         * Test that submissions are filtered by date range.
         *
         * This sets a specific date range and verifies that submissions
         * outside of this range are not displayed.
         */
        public function submissions_are_filtered_by_date()
        {
            $dateFrom = now()->subDays(10)->format('Y-m-d');
            $dateTo = now()->subDays(5)->format('Y-m-d');

            Livewire::test(Submissions::class, ['location' => $this->location])
                ->set('dateFrom', $dateFrom)
                ->set('dateTo', $dateTo)
                ->assertDontSee('Sample Value'); // Assuming no submissions fall in this date range
        }

        /**
         * @test
         * Test that submissions are filtered by a text search.
         *
         * This verifies that submissions containing a specific text are visible
         * after setting the search term and selected form component.
         */
        public function submissions_are_filtered_by_text_search()
        {
            Livewire::test(Submissions::class, ['location' => $this->location])
                ->set('search', 'Sample Value')
                ->set('select', 'Sample Text Label')
                ->assertSee('Sample Value'); // Check if submission with the value is visible
        }

        /**
         * @test
         * Test that submissions can be exported to an Excel file.
         *
         * This verifies that the export function downloads an Excel file
         * with the expected filename format.
         */
        public function export_to_excel()
        {
            $expectedFilename = $this->generateExpectedFilename('xlsx');

            Livewire::test(Submissions::class, ['location' => $this->location])
                ->call('exportToExcel')
                ->assertFileDownloaded($expectedFilename);
        }

        /**
         * @test
         * Test that submissions can be exported to a CSV file.
         *
         * This verifies that the export function downloads a CSV file
         * with the expected filename format.
         */
        public function export_to_csv()
        {
            $expectedFilename = $this->generateExpectedFilename('csv');

            Livewire::test(Submissions::class, ['location' => $this->location])
                ->call('exportToCsv')
                ->assertFileDownloaded($expectedFilename);
        }

        /**
         * @test
         * Test setting the timezone for the user.
         *
         * This ensures that the timezone is set correctly within the component.
         */
        public function timezone_is_set_correctly()
        {
            Livewire::test(Submissions::class, ['location' => $this->location])
                ->call('setTimezone', 'America/New_York')
                ->assertSet('userTimezone', 'America/New_York'); // Check if the timezone is set
        }

        /**
         * Generate the expected filename based on the user's team and location names.
         *
         * @param string $extension File extension (e.g., 'csv', 'xlsx')
         * @return string The expected filename.
         */
        private function generateExpectedFilename(string $extension): string
        {
            $teamName = preg_replace('/[^A-Za-z0-9\- ]/', '', $this->user->currentTeam->name);
            $locationName = preg_replace('/[^A-Za-z0-9\- ]/', '', $this->location->name);

            return str_replace(' ', '-', $teamName) . '_' . str_replace(' ', '-', $locationName) . '_' . now()->format('Y-m-d') . '.' . $extension;
        }
    }
