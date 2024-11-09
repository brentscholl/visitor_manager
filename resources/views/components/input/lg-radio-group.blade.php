@props([
    'index' => 0,  // Default index of the initially selected radio button
    'label' => ''  // Optional label for the radio group
])

<!-- Fieldset to contain the radio group -->
<fieldset
    {{ $attributes }}
    x-data="window.Components.radioGroup({ initialCheckedIndex: {{ $index }} })"
    x-init="init()"
>
    <!-- Display the label as a legend if provided -->
    @if($label)
        <legend class="text-sm font-medium text-gray-900">
            {{ $label }}
        </legend>
    @endif

    <!-- Container for radio options, styled to support different layouts -->
    <div class="mt-2 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
        {{ $slot }}
    </div>
</fieldset>
