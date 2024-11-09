@props([
    'values' => [20, 50, 100] // Default values for "Per Page" options
])

<div class="md:col-span-1 col-span-12">
    <label for="location" class="block text-sm leading-5 font-medium text-gray-700">Per Page</label>
    <div class="form-input-container">
        <select wire:model="perPage" id="location" class="form-input-container__input">
            @foreach($values as $value)
                <option>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
