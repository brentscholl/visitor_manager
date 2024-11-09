<?php

    namespace App\Livewire;

    use Livewire\Component;

    /**
     * Component to display a flash message overlay with customizable styles.
     */
    class FlashOverlay extends Component
    {
        /**
         * @var array|string The content of the flash overlay message.
         */
        public $message;

        /**
         * @var array CSS styles specific to the overlay flash message.
         */
        public $styles = [];

        /**
         * @var bool Controls whether the overlay is shown.
         */
        public $shown = true;

        /**
         * Initialize the component with the given message and apply overlay-specific styles.
         *
         * @param array|string $message The flash message to display in the overlay.
         */
        public function mount($message)
        {
            // Ensure the message is in array format for consistent handling.
            if (!is_array($message)) {
                $message = (array) $message;
            }

            $this->message = $message;

            // Retrieve overlay styles from configuration.
            $this->styles = config('livewire-flash.styles.overlay');
        }

        /**
         * Dismiss the overlay, hiding it from view.
         */
        public function dismiss()
        {
            $this->shown = false;
        }

        /**
         * Render the flash overlay view.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            return view('livewire.flash-overlay');
        }
    }
