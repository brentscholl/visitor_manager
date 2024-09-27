<section>
    @foreach ($messages as $index => $message)
        @if ($message['overlay'])
            <livewire:flash-overlay :message="$message" :key="'lwfo_' . $index" />
        @endif
    @endforeach
    <div class="max-w-sm w-full fixed bottom-20 right-6 z-50">
        @foreach ($messages as $index => $message)
            @if (!$message['overlay'])
                <livewire:flash-message :message="$message" :key="'lwfm_' . $index" />
            @endif
        @endforeach
    </div>
</section>
