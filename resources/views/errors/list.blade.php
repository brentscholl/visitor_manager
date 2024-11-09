@if($errors->all())
    {{-- Check if there are any error messages --}}
    <div class="bg-red-100 py-2 pl-3 pr-8 rounded-md relative mb-2">
        <ul class="text-xs list-disc">
            {{-- Loop through each error message and display it in a list --}}
            @foreach($errors->all() as $message)
                <li class="text-red-500">{{ $message }}</li>
            @endforeach
        </ul>
        {{-- Icon to indicate an error at the top right corner --}}
        <div class="text-red-500 absolute top-2 right-2">
            <x-svg.error class="h-4 w-4"/>
        </div>
    </div>
@endif
