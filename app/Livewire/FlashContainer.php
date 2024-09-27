<?php

namespace App\Livewire;

use Livewire\Component;

class FlashContainer extends Component
{
    public $messages = [];

    protected $listeners = ['flashMessageAdded'];

    public function mount()
    {
        // grab any normal flash messages and render them
        $this->messages = session('flash_notification', collect())->toArray();
        session()->forget('flash_notification');
    }

    public function flashMessageAdded($message)
    {
        $this->messages[] = $message;
    }

    public function dismissMessage($key)
    {
        unset($this->messages[$key]);
    }

    public function render()
    {
        return view('livewire.flash-container');
    }
}
