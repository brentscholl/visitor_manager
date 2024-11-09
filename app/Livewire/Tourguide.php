<?php

    namespace App\Livewire;

    use Livewire\Component;

    /**
     * Component to manage and control user onboarding tours within the application.
     */
    class Tourguide extends Component
    {
        /**
         * List of event listeners handled by this component.
         */
        protected $listeners = ['tourFinished', 'restartTour'];

        /**
         * Mark a specific tour as finished by updating the user's settings.
         *
         * @param string $tour The name of the tour that was completed.
         */
        public function tourFinished($tour)
        {
            switch ($tour) {
                case 'welcome':
                    auth()->user()->settings()->update('tour_welcome', false);
                    break;
                case 'locations':
                    auth()->user()->settings()->update('tour_locations', false);
                    break;
                case 'submissions':
                    auth()->user()->settings()->update('tour_submissions', false);
                    break;
            }
        }

        /**
         * Restart a specific tour by updating the user's settings.
         *
         * @param string $tour The name of the tour to restart.
         * @return \Illuminate\Http\RedirectResponse Redirects the user to the previous page.
         */
        public function restartTour($tour)
        {
            switch ($tour) {
                case 'welcome':
                    auth()->user()->settings()->set('tour_welcome', true);
                    break;
                case 'locations':
                    auth()->user()->settings()->set('tour_locations', true);
                    break;
                case 'submissions':
                    auth()->user()->settings()->set('tour_submissions', true);
                    break;
            }

            // Redirect back to the previous page
            return redirect(request()->header('Referer'));
        }

        /**
         * Render the tour guide view.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            return view('livewire.tourguide');
        }
    }
