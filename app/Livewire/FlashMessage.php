<?php

namespace App\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    public $message;
    public $styles = [];

    public $shown = true;

    public function mount($message)
    {
        if (!is_array($message)) {
            $message = (array) $message;
        }
        $this->message = $message;
        $this->styles = config('livewire-flash.styles.' . $this->message['level']);
    }

    public function dismiss()
    {
        $this->shown = false;
    }

    public function render()
    {
        return view('livewire.flash-message');
    }
}
