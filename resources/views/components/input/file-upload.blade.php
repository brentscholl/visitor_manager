@props([
    'label' => "",              // Label for the file input
    'acceptedFileTypes' => [],  // Array of accepted file types (e.g., ['image/jpeg', 'application/pdf'])
    'maxFileSize' => '10MB',    // Maximum file size allowed
])

<div class="{{ $attributes->get('class') }}"
    wire:ignore
    wire:key="data_{{ $attributes->whereStartsWith('wire:model')->first() }}"
    x-data=""
    x-init="
        // Initialize FilePond options
        FilePond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            itemInsertLocation: 'after',
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                },
                load: (source, load, error, progress, abort, headers) => {
                    var myRequest = new Request(source);
                    fetch(myRequest).then(function(response) {
                      response.blob().then(function(myBlob) {
                        load(myBlob)
                      });
                    });
                },
                onremovefile(error, file) {
                    if (file.source === parseInt(file.source, 10)) {
                        @this.removeFile(file.source);
                    }
                },
            },
        });

        // Create FilePond instance
        const pond = FilePond.create($refs.input, {
            @if($acceptedFileTypes)
            acceptedFileTypes: [
                @foreach($acceptedFileTypes as $type)
                    '{{ $type }}',
                @endforeach
            ],
            @endif

            allowImageResize: true,
            imageResizeTargetWidth: '300px',
            imageResizeTargetHeight: '300px',
            filePosterMaxHeight: '256px',
            maxFileSize: '{{ $maxFileSize }}',
        });

        // Reset FilePond when 'pondReset' event is dispatched
        this.addEventListener('pondReset', e => {
            pond.removeFiles();
        });
    "
>
    <!-- Label for the file input -->
    <label for="{{ $attributes->whereStartsWith('wire:model')->first() }}">{!! $label !!}</label>

    <!-- File Input Field -->
    <div class="mt-1 relative rounded-md">
        <input
            {{ $attributes->whereStartsWith('wire:model') }}
            id="{{ $attributes->whereStartsWith('wire:model')->first() }}"
            {{ isset($attributes['multiple']) ? 'multiple' : '' }}
            type="file" x-ref="input">
    </div>

    <!-- Error Message Display -->
    @error($attributes->whereStartsWith('wire:model')->first())
    <p wire:key="error_{{ $attributes->whereStartsWith('wire:model')->first() }}"
        class="mt-2 text-sm text-red-600"
        id="{{ $attributes->whereStartsWith('wire:model')->first() }}-error"
    >
        {{ $message }}
    </p>
    @enderror
</div>
