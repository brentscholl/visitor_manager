@once
    <!-- Push Flatpickr CSS to the styles stack once -->
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush

    <!-- Push Flatpickr JavaScript to the scripts header stack once -->
    @push('scripts.header')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush
@endonce
