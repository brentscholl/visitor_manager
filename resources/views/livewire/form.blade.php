<div class="px-4 py-20 bg-gray-100 flex justify-center" style="min-height: 100vh">
    @if($location->settings()->get('enableVisitorDeviceSignIn', true))
    <x-modal wire:model="showQRCode">
        <x-slot name="title"></x-slot>
        <div class="flex flex-col justify-center items-center space-y-6">
            {!! QrCode::size(150)->generate( route('forms.show', ['uuid' => $location->id, 'isVisitor' => 'true'])); !!}
            <p class="text-center text-lg max-w-lg">To complete the form using your personal device, please scan the QR code displayed above.</p>
            <p class="text-center text-sm">Alternatively, you can complete the form on this device.</p>
        </div>
        <x-slot name="footer">
            <div class="flex justify-center w-full">
                <x-button btn="primary" type="button" wire:click="$set('showQRCode', false)">
                    {{ __('Fill out form on this device') }}
                </x-button>
            </div>
        </x-slot>
    </x-modal>
    @endif
    <div class="w-full max-w-lg space-y-4">
        <div class="flex justify-end items-center">
            @if($location->settings()->get('enableVisitorDeviceSignIn', true))
                <x-button btn="simple" type="button" wire:click="$toggle('showQRCode')">
                    {{ __('Fill out form on your device') }}
                </x-button>
            @endif
        </div>
        @foreach($layout as $i => $item)
            @switch($item['layout'])
                @case('text')
                    <x-input.text
                            wire:model="form.{{ $item['id'] }}.value"
                            id="preview-{{$i}}-input"
                            label="{{ $item['inputs']['label'] }}"
                            placeholder="{{ $item['inputs']['placeholder'] }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
                    />
                    @break
                @case('email')
                    <x-input.text
                            wire:model="form.{{ $item['id'] }}.value"
                            type="email"
                            id="preview-{{$i}}-input"
                            label="{{ $item['inputs']['label'] }}"
                            placeholder="{{ $item['inputs']['placeholder'] }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
                    />
                    @break
                @case('phone')
                    <x-input.text
                            wire:model="form.{{ $item['id'] }}.value"
                            id="preview-{{$i}}-input"
                            label="{{ $item['inputs']['label'] }}"
                            placeholder="{{ $item['inputs']['placeholder'] }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
                    />
                    @break
                @case('number')
                    <x-input.text
                            wire:model="form.{{ $item['id'] }}.value"
                            type="number"
                            id="preview-{{$i}}-input"
                            label="{{ $item['inputs']['label'] }}"
                            min="{{  $item['inputs']['use-min'] ? $item['inputs']['min'] : 0 }}"
                            max="{{  $item['inputs']['use-max'] ? $item['inputs']['max'] : 100000000000 }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
                    />
                    @break
                @case('paragraph')
                    <x-input.textarea
                            wire:model="form.{{ $item['id'] }}.value"
                            id="preview-{{$i}}-input"
                            label="{{ $item['inputs']['label'] }}"
                            placeholder="{{ $item['inputs']['placeholder'] }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
                    />
                    @break
                @case('drop-down')
                    <x-input.select
                            wire:model="form.{{ $item['id'] }}.value"
                            id="preview-{{$i}}-input"
                            label="{{ $item['inputs']['label'] }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
                    >
                        <option value="" selected disabled>Select Option</option>
                        @foreach($item['inputs']['options'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </x-input.select>
                    @break
                @case('checkboxes')
                    <x-input.checkbox-set
                            id="preview-{{$i}}-input"
                            label="{{ $item['inputs']['label'] }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
                            :inline="$item['inputs']['inline']"
                    >
                        @foreach($item['inputs']['options'] as $key => $option)
                            <x-input.checkbox
                                    wire:model="form.{{ $item['id'] }}.value.{{ $key }}"
                                    id="preview-{{$i}}-input-{{ $key }}"
                                    value="{{ $option }}"
                                    label="{{ $option }}"
                            />
                        @endforeach
                    </x-input.checkbox-set>
                    @break
                @case('radio-buttons')
                    {{--            Use this to set the initial checked value. --}}
                    @php($type_index = 0)
                    @foreach($item['inputs']['options'] as $option)
                        @if($option == $item['inputs']['label'])
                            @php($type_index = $loop->index)
                        @endif
                    @endforeach
                    <x-input.lg-radio-group
                            id="preview-{{$i}}-input"
                            label="{{ $item['inputs']['label'] }}"
                            :index="$type_index"
                    >
                        @foreach($item['inputs']['options'] as $option)
                            <x-input.lg-radio
                                    wire:model="form.{{ $item['id'] }}.value"
                                    id="preview-{{$i}}-input-{{ $loop->index }}"
                                    value="{{ $option }}"
                            >{{ $option }}</x-input.lg-radio>
                        @endforeach
                    </x-input.lg-radio-group>
                    @break
                @case('consent')
                    <x-input.checkbox
                            wire:model="form.{{ $item['id'] }}.value"
                            id="preview-{{$i}}-input-{{ $loop->index }}"
                            value="{{ $item['inputs']['message'] }}"
                            label="{{ $item['inputs']['message'] }}"
                    />
                    @break
                @case('date')
                    <x-input.date
                            wire:model="form.{{ $item['id'] }}.value"
                            label="{{ $item['inputs']['label'] }}"
                            id="preview-{{$i}}-input-{{ $loop->index }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
                    />
                    @break
                @case('time')
                    <x-input.time
                            wire:model="form.{{ $item['id'] }}.value"
                            id="preview-{{$i}}-input-{{ $loop->index }}"
                            label="{{ $item['inputs']['label'] }}"
                            :required="$item['inputs']['required']"
                            :optional="$item['inputs']['show-optional-flag']"
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
        @endforeach
        @if($errors->all())
            <div class="bg-red-100 py-2 pl-3 pr-8 rounded-md relative mb-2">
                <p class="text-red-500 mb-3">Please correct these errors before submitting.</p>
                <ul class="text-xs list-disc">
                    @foreach($errors->all() as $message)
                        <li class="text-red-500">{{ $message }}</li>
                    @endforeach
                </ul>
                <div class="text-red-500 absolute top-2 right-2">
                    <x-svg.error class="h-4 w-4"/>
                </div>
            </div>
        @endif
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <x-button btn="simple" type="button" wire:click="$toggle('showClearForm')">
                {{ __('Clear Form') }}
            </x-button>
            <x-modal wire:model.live="showClearForm" type="danger">
                Are you sure you want to clear this form of all your responses?
                <x-slot name="footer">
                    <x-button btn="simple" type="button"
                        wire:click="$toggle('showClearForm')">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button btn="danger" type="button" class="ml-2"
                        wire:click="cancel">
                        {{ __('Clear Form') }}
                    </x-button>
                </x-slot>
            </x-modal>
            <x-button btn="primary" :loader="true" wire:target="submit" type="button" class="ml-2" wire:click="submit">
                {{ __('Submit') }}
            </x-button>
        </div>
    </div>
</div>
