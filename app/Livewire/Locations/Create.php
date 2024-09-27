<?php

    namespace App\Livewire\Locations;

    use App\Models\Location;
    use Illuminate\Validation\Rule;
    use Livewire\Component;
    use Illuminate\Database\Query\Builder;

    class Create extends Component
    {
        public $showCreateModal = false;

        public $name;

        public function rules()
        {
            return [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('locations')->where(fn (Builder $query) => $query->where('team_id', auth()->user()->currentTeam->id)),
                ],
            ];
        }

        public function createLocation()
        {
            $this->validate();

            Location::create([
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'name' => $this->name,
                'team_id' => auth()->user()->currentTeam->id,
                'user_id' => auth()->user()->id,
            ]);

            $this->showCreateModal = false;

            flash('Location created successfully!')->success()->livewire($this);

            $this->reset();

            $this->dispatch('locationCreated');
        }

        public function updatedShowCreateModal($value)
        {
            if (! $value) {
                $this->reset();
            }
        }

        public function render()
        {
            return view('livewire.locations.create');
        }
    }
