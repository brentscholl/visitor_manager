<?php

    namespace App\Livewire;

    use Livewire\Component;

    /**
     * Component to display an individual flash message with customizable styles.
     */
    class FlashMessage extends Component
    {
        /**
         * @var array|string The flash message content.
         */
        public $message;

        /**
         * @var array CSS styles for the flash message, based on the message level.
         */
        public $styles = [];

        /**
         * @var bool Controls whether the message is shown.
         */
        public $shown = true;

        /**
         * Initialize the component with the given message and apply styles based on its level.
         *
         * @param array|string $message The flash message to display.
         */
        public function mount($message)
        {
            // Ensure the message is in array format for consistent handling.
            if (!is_array($message)) {
                $message = (array) $message;
            }

            $this->message = $message;

            // Retrieve styles from configuration based on the message level (e.g., success, error).
            $this->styles = config('livewire-flash.styles.' . ($this->message['level'] ?? 'default'));
        }

        /**
         * Dismiss the flash message, hiding it from view.
         */
        public function dismiss()
        {
            $this->shown = false;
        }

        /**
         * Render the flash message view.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            return view('livewire.flash-message');
        }
    }
