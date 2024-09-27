@if(auth()->user()->settings()->get('tour_submissions'))
    @include('tours.tour-scripts')
    @section('scripts.footer')
        <script>
            // Tour steps
            let steps = [
                {
                    title: 'Submissions',
                    intro: 'Easily access and review all form submissions.',
                },

                {
                    element: document.querySelector('.tour__submissions--1'),
                    title: 'Search and Filtering',
                    intro: 'Leverage the search and filtering tools to pinpoint the exact submissions you\'re looking for.',
                    position: 'top'
                },

                {
                    element: document.querySelector('.tour__submissions--2'),
                    title: 'Download Excel and CSV files',
                    intro: 'Download your submissions in either Excel or CSV format. When filters or search criteria are active, only the relevant submissions will be included in the download.',
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
                Livewire.dispatch('tourFinished', { tour: 'submissions' });
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
