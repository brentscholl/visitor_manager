{{-- Flash container for displaying flash messages, both overlay and fixed notifications --}}
<section>
    {{-- Loop through messages and display overlay messages --}}
    @foreach ($messages as $index => $message)
        @if ($message['overlay'])
            <livewire:flash-overlay :message="$message" :key="'lwfo_' . $index" />
        @endif
    @endforeach

    {{-- Container for fixed flash messages positioned at the bottom right --}}
    <div class="max-w-sm w-full fixed bottom-20 right-6 z-50">
        {{-- Loop through messages and display non-overlay messages --}}
        @foreach ($messages as $index => $message)
            @if (!$message['overlay'])
                <livewire:flash-message :message="$message" :key="'lwfm_' . $index" />
            @endif
        @endforeach
    </div>
</section>
