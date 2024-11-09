<?php

    namespace Tests\Feature\Livewire\Locations;

    use App\Livewire\Locations\FormBuilder;
    use App\Models\FormComponent;
    use App\Models\Location;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Str;
    use Livewire\Livewire;
    use Tests\TestCase;

    /**
     * Test suite for the FormBuilder Livewire component, which allows users to
     * create and manage form layouts for a given location.
     */
    class FormBuilderTest extends TestCase
    {
        use RefreshDatabase;

        protected $user;
        protected $location;

        /**
         * Set up each test by creating and authenticating a user with a location.
         */
        protected function setUp(): void
        {
            parent::setUp();

            $this->user = User::factory()->withPersonalTeam()->create();
            $this->actingAs($this->user);

            // Disable tour to avoid pre-loading components
            $this->user->settings()->update('tour_locations', false);

            $this->location = Location::factory()->create([
                'user_id' => $this->user->id,
                'team_id' => $this->user->currentTeam->id,
            ]);
        }

        /**
         * @test
         * Test that the FormBuilder component can render successfully.
         */
        public function form_builder_component_can_render()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->assertStatus(200)
                ->assertSet('location.id', $this->location->id)
                ->assertSet('enableVisitorDeviceSignIn', true);
        }

        /**
         * @test
         * Test that the initial form layout can be loaded correctly.
         */
        public function can_load_initial_form_layout()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->call('loadLayout')
                ->assertSet('layout', []);
        }

        /**
         * @test
         * Test adding a new form component to the layout.
         *
         * This verifies that a new component can be added and initialized with default values.
         */
        public function can_add_new_form_component()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->call('addComponent', 'text')
                ->assertSet('layout.0.layout', 'text')
                ->assertSet('layout.0.inputs.label', ''); // The label is initially blank
        }

        /**
         * @test
         * Test removing a form component from the layout.
         *
         * This verifies that a component can be removed and that the layout is updated accordingly.
         */
        public function can_remove_form_component()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->call('addComponent', 'text')
                ->call('removeComponent', 0)
                ->assertSet('layout', []); // Expecting an empty layout after removal
        }

        /**
         * @test
         * Test toggling the visitor device sign-in setting.
         *
         * This verifies that the enableVisitorDeviceSignIn property can be updated.
         */
        public function can_toggle_visitor_device_sign_in()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->set('enableVisitorDeviceSignIn', false)
                ->call('toggleEnableVisitorDeviceSignIn')
                ->assertSet('enableVisitorDeviceSignIn', false);
        }

        /**
         * @test
         * Test creating a form with a specific layout.
         *
         * This ensures that the created layout is stored in the database with correct data.
         */
        public function can_create_form_with_layout()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->call('addComponent', 'text')
                ->set('layout.0.inputs.label', 'Sample Text Label')
                ->call('addComponent', 'paragraph')
                ->set('layout.1.inputs.label', 'Sample Paragraph Label')
                ->call('createForm');

            // Check if text component exists in the database
            $this->assertDatabaseHas('form_components', [
                'location_id' => $this->location->id,
                'type' => 'text',
            ]);
            $this->assertDatabaseHas('form_components', [
                'location_id' => $this->location->id,
                'type' => 'paragraph',
            ]);

            // Validate the actual stored JSON structure in the `inputs` column
            $textComponent = FormComponent::where('location_id', $this->location->id)
                ->where('type', 'text')
                ->first();
            $this->assertEquals([
                'label' => 'Sample Text Label',
                'placeholder' => '',
                'required' => 0,
                'show-optional-flag' => 0,
            ], json_decode($textComponent->inputs, true));

            $paragraphComponent = FormComponent::where('location_id', $this->location->id)
                ->where('type', 'paragraph')
                ->first();
            $this->assertEquals([
                'label' => 'Sample Paragraph Label',
                'placeholder' => '',
                'required' => 0,
                'show-optional-flag' => 0,
            ], json_decode($paragraphComponent->inputs, true));
        }

        /**
         * @test
         * Test updating an existing form layout.
         *
         * This ensures that additional components can be added to an existing layout
         * and that updates are persisted correctly in the database.
         */
        public function can_update_form_layout()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->call('addComponent', 'text')
                ->set('layout.0.inputs.label', 'Sample Text Label')
                ->call('createForm');

            Livewire::test(FormBuilder::class, ['location' => $this->location->fresh()])
                ->call('addComponent', 'paragraph')
                ->set('layout.1.inputs.label', 'Updated Paragraph Label')
                ->call('updateForm');

            // Confirm the updated paragraph component
            $paragraphComponent = FormComponent::where('location_id', $this->location->id)
                ->where('type', 'paragraph')
                ->first();
            $this->assertEquals([
                'label' => 'Updated Paragraph Label',
                'placeholder' => '',
                'required' => 0,
                'show-optional-flag' => 0,
            ], json_decode($paragraphComponent->inputs, true));
        }

        /**
         * @test
         * Test moving a form component within the layout.
         *
         * This verifies that components can be reordered by moving them up or down.
         */
        public function can_move_form_component()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->call('addComponent', 'text')
                ->call('addComponent', 'email')
                ->call('moveComponent', 'up', 1)
                ->assertSet('layout.0.layout', 'email')
                ->assertSet('layout.1.layout', 'text');
        }

        /**
         * @test
         * Test adding and removing options in a component.
         *
         * This ensures that options for components like drop-downs can be managed dynamically.
         */
        public function can_add_and_remove_options_in_component()
        {
            Livewire::test(FormBuilder::class, ['location' => $this->location])
                ->call('addComponent', 'drop-down')
                ->call('addOption', 0) // Ensures options array is initialized in component
                ->assertCount('layout.0.inputs.options', 2)
                ->call('removeOption', 0, 1)
                ->assertCount('layout.0.inputs.options', 1);
        }
    }
