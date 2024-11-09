@props([
    'item',
    'i',
    'wireModel' => null,
])

<div>
    @switch($item['layout'])
        @case('text')
            <x-input.text
                :wire:model="$wireModel"
                :disableErrors="!$wireModel"
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                placeholder="{{ $item['inputs']['placeholder'] ?? '' }}"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
            />
            @break

        @case('email')
            <x-input.text
                :wire:model="$wireModel"
                :disableErrors="!$wireModel"
                type="email"
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                placeholder="{{ $item['inputs']['placeholder'] ?? '' }}"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
            />
            @break

        @case('phone')
            <x-input.text
                :wire:model="$wireModel"
                :disableErrors="!$wireModel"
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                placeholder="{{ $item['inputs']['placeholder'] ?? '' }}"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
            />
            @break

        @case('number')
            <x-input.text
                :wire:model="$wireModel"
                :disableErrors="!$wireModel"
                type="number"
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                min="{{ $item['inputs']['use-min'] ? $item['inputs']['min'] : 0 }}"
                max="{{ $item['inputs']['use-max'] ? $item['inputs']['max'] : 100000000000 }}"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
            />
            @break

        @case('paragraph')
            <x-input.textarea
                :wire:model="$wireModel"
                :disableErrors="!$wireModel"
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                placeholder="{{ $item['inputs']['placeholder'] ?? '' }}"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
            />
            @break

        @case('drop-down')
            <x-input.select
                :wire:model="$wireModel"
                :disableErrors="!$wireModel"
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
            >
                <option value="" selected disabled>Select Option</option>
                @foreach($item['inputs']['options'] as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </x-input.select>
            @break

        @case('checkboxes')
            <x-input.checkbox-set
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
                :inline="$item['inputs']['inline']"
            >
                @foreach($item['inputs']['options'] as $option)
                    <x-input.checkbox
                        :wire:model="$wireModel ? $wireModel.'.'.$loop->index : null"
                        id="form-{{$i}}-input-{{ $loop->index }}"
                        value="{{ $option }}"
                        label="{{ $option }}"
                    />
                @endforeach
            </x-input.checkbox-set>
            @break

        @case('radio-buttons')
            @php($type_index = 0)
            @foreach($item['inputs']['options'] as $option)
                @if($option == $item['inputs']['label'])
                    @php($type_index = $loop->index)
                @endif
            @endforeach
            <x-input.lg-radio-group
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                :index="$type_index"
            >
                @foreach($item['inputs']['options'] as $option)
                    <x-input.lg-radio
                        :wire:model="$wireModel"
                        id="form-{{$i}}-input-{{ $loop->index }}"
                        value="{{ $option }}"
                    >{{ $option }}</x-input.lg-radio>
                @endforeach
            </x-input.lg-radio-group>
            @break

        @case('consent')
            <x-input.checkbox
                :wire:model="$wireModel"
                id="form-{{$i}}-input"
                value="{{ $item['inputs']['message'] }}"
                label="{{ $item['inputs']['message'] }}"
            />
            @break

        @case('date')
            <x-input.date
                :wire:model="$wireModel"
                :disableErrors="!$wireModel"
                label="{{ $item['inputs']['label'] }}"
                id="form-{{$i}}-input"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
            />
            @break

        @case('time')
            <x-input.time
                :wire:model="$wireModel"
                :disableErrors="!$wireModel"
                id="form-{{$i}}-input"
                label="{{ $item['inputs']['label'] }}"
                :required="$item['inputs']['required'] ?? false"
                :optional="$item['inputs']['show-optional-flag'] ?? false"
            />
            @break

        @case('divider')
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                @if($item['inputs']['divide-label'])
                    <div class="relative flex justify-center">
                        <span class="bg-gray-100 px-2 text-sm text-gray-500">{{ $item['inputs']['divide-label'] }}</span>
                    </div>
                @endif
            </div>
            @break

        @case('header')
            <h2 class="text-lg font-semibold">{{ $item['inputs']['content'] }}</h2>
            @break

        @case('message')
            <p>{{ $item['inputs']['message'] }}</p>
            @break
    @endswitch
</div>
