<?php

namespace App\Livewire;

use Livewire\Component;

class Tourguide extends Component
{
    protected $listeners = ['tourFinished', 'restartTour'];

    public function tourFinished($tour)
    {
        switch ($tour) {
            case('welcome'):
                auth()->user()->settings()->update('tour_welcome', false);
                break;
            case('locations'):
                auth()->user()->settings()->update('tour_locations', false);
                break;
            case('submissions'):
                auth()->user()->settings()->update('tour_submissions', false);
                break;
        }
    }

    public function restartTour($tour)
    {
        switch ($tour) {
            case('welcome'):
                auth()->user()->settings()->set('tour_welcome', true);
                break;
            case('locations'):
                auth()->user()->settings()->set('tour_locations', true);
                break;
            case('submissions'):
                auth()->user()->settings()->set('tour_submissions', true);
                break;
        }
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.tourguide');
    }
}
