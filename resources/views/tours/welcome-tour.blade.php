@if(auth()->user()->settings()->get('tour_welcome'))
    @include('tours.tour-scripts')
    @section('scripts.footer')
        <script>
            // Tour steps
            let steps = [
                {
                    title: 'Welcome to Gatekeeper',
                    intro: 'Let us show you around your new dashboard.',
                },
                {
                    element: document.querySelector('.tour__welcome--1'),
                    title: 'Create your first location.',
                    intro: 'Each location serves as a form where you can gather customer information by having them fill it out.',
                    position: 'left',
                },
                {
                    element: document.querySelector('.tour__welcome--2'),
                    title: 'Your Locations',
                    intro: 'Here is a list of the locations you have created.',
                    position: 'top',
                },
                {
                    element: document.querySelector('.tour__welcome--3'),
                    title: 'Edit Your Form.',
                    intro: 'Edit the form\'s layout and input elements.',
                    position: 'bottom',
                },
                {
                    element: document.querySelector('.tour__welcome--4'),
                    title: 'Form Submissions.',
                    intro: 'View the submissions associated with this form.',
                    position: 'bottom',
                },
                {
                    element: document.querySelector('.tour__welcome--5'),
                    title: 'Connect to Tablet',
                    intro: 'Provides a QR code for tablet scanning, allowing you to open the form on your tablet with ease.',
                    position: 'bottom',
                },
                {
                    element: document.querySelector('.tour__welcome--6'),
                    title: 'Team Settings',
                    intro: 'Explore additional options for your team, such as changing your team\'s name and inviting new team members.',
                    position: 'left',
                },
                {
                    element: document.querySelector('.tour__welcome--7'),
                    title: 'Profile',
                    intro: 'Explore additional options for your profile.',
                    position: 'left',
                    onbeforechange: function () {
                        document.querySelector('.tour__welcome--6').dispatchEvent(new CustomEvent('open-profile-menu'));
                    }
                },
            ]

            let options = {
                doneLabel : 'Finish Tour',
                scrollToElement: true,
                scrollPadding: 80,
                steps: steps
            };

            // Tour Exit Event
            let exit = function () {
                // Update user settings here so tour doesn't show again.
                Livewire.dispatch('tourFinished', { tour: 'welcome' })
            }

            let complete = function () {
                // Redirect to url on complete
                // Livewire.dispatch('restartTour', { tour: 'tracking-numbers' });
                {{--window.location.href = '{{ \URL::route('/dashboard', [], false) }}'--}}
            }

            // Run tour
            tour(options, exit, complete);
        </script>
    @endsection
@endif
