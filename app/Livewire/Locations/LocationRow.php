<?php

namespace App\Livewire\Locations;

use App\Models\Location;
use App\Traits\HasMenu;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LocationRow extends Component
{
    use HasMenu;

    public $location;
    public $deleteLocation = false;
    public $renameLocation = false;
    public $name;
    public $showConnectModal = false;
    public $hasLayout = false;

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

    public function mount(Location $location)
    {
        $this->location = $location;
        $this->name = $this->location->name;
        if ($this->location->formComponents && auth()->user()->settings()->get('tour_welcome')) {
            $this->hasLayout = true;
        }else {
            $this->hasLayout = $this->location->formComponents()->count() > 0 || $this->location->submissions()->count() > 0;
        }
    }

    public function changeLocationName()
    {
        abort_unless($this->location->team_id === auth()->user()->currentTeam->id, 403);

        $this->validate();

        $this->location->update([
            'name' => $this->name,
        ]);

        $this->name = $this->location->name;

        $this->renameLocation = false;

        flash('Location renamed successfully!')->success()->livewire($this);

        $this->dispatch('locationUpdated');
    }

    public function removeLocation()
    {
        abort_unless($this->location->team_id === auth()->user()->currentTeam->id, 403);

        $this->location->delete();

        flash('Location deleted successfully!')->success()->livewire($this);

        $this->dispatch('locationDeleted');
    }

    public function render()
    {
        return view('livewire.locations.location-row');
    }
}
