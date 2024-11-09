<?php

    namespace App\Livewire;

    use Livewire\Component;

    /**
     * Component to display flash messages to the user.
     */
    class FlashContainer extends Component
    {
        /**
         * @var array Stores flash messages to be displayed.
         */
        public $messages = [];

        /**
         * List of event listeners handled by this component.
         */
        protected $listeners = ['flashMessageAdded'];

        /**
         * Initialize the component with any existing session flash messages.
         */
        public function mount()
        {
            // Retrieve flash messages from the session and store them in $messages.
            $this->messages = session('flash_notification', collect())->toArray();

            // Clear flash messages from the session to prevent duplicate rendering.
            session()->forget('flash_notification');
        }

        /**
         * Handle a new flash message added via events.
         *
         * @param array $message The new flash message to add.
         */
        public function flashMessageAdded($message)
        {
            $this->messages[] = $message;
        }

        /**
         * Dismiss a specific flash message by its key.
         *
         * @param int $key The index of the message to dismiss.
         */
        public function dismissMessage($key)
        {
            unset($this->messages[$key]);
        }

        /**
         * Render the flash container view.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            return view('livewire.flash-container');
        }
    }
