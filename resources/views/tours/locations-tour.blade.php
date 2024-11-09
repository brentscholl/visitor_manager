@if(auth()->user()->settings()->get('tour_locations'))
    @include('tours.tour-scripts')
    @section('scripts.footer')
        <script>
            // Tour steps
            let steps = [
                {
                    title: 'Building the Form for this Location',
                    intro: 'This page allows you to create the form that your visitors will fill out.',
                },
                {
                    element: document.querySelector('.tour__locations--1'),
                    title: 'Form Layout',
                    intro: 'Customize the layout and input elements for your form right here.',
                    position: 'top'
                },
                {
                    element: document.querySelector('.tour__locations--2'),
                    title: 'Preview Your Form',
                    intro: 'Get a sneak peek at how your form will appear to users.',
                    position: 'top'
                },
                {
                    element: document.querySelector('.tour__locations--3'),
                    title: 'Adding Components',
                    intro: 'Easily add components like text fields, checkboxes, and date pickers to your form by clicking this button.',
                    position: 'top'
                },
                {
                    element: document.querySelector('.tour__locations--4'),
                    title: 'Customizing Form Components',
                    intro: 'When adding form inputs, keep in mind that by default, all fields are optional. However, if you wish to make certain fields mandatory, you can mark them as required. Additionally, if you want to emphasize that a field is optional, you can add an \'Optional\' flag.',
                    position: 'top'
                },
                {
                    element: document.querySelector('.tour__locations--5'),
                    title: 'Rearrange Form Components',
                    intro: 'Adjust the order of form components using these buttons.',
                    position: 'right'
                },
                {
                    element: document.querySelector('.tour__locations--6'),
                    title: 'Visitor Self-Sign In',
                    intro: 'Enable visitors to sign in on their own devices by scanning a QR code.',
                    position: 'right'
                },
                {
                    element: document.querySelector('.tour__locations--7'),
                    title: 'Save Your Form',
                    intro: "Don't forget to save your form to keep all your updates intact.",
                    position: 'left'
                }

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
                Livewire.dispatch('tourFinished', { tour: 'locations'})
            }

            let complete = function () {
                // Redirect to url on complete
                // Livewire.dispatch('restartTour', 'tracking-numbers');
                {{--window.location.href = '{{ \URL::route('upload-invoices', [], false) }}'--}}
            }

            // Run tour
            tour(options, exit, complete);
        </script>
    @endsection
@endif
