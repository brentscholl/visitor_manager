<?php

return [
    'views' => [
        'container' => 'flash.flash-container',
        'message'   => 'flash.message',
        'overlay'   => 'flash.overlay',
    ],
    'styles' => [
        'info' => [
            'bg-color'     => 'bg-blue-100',
            'border-color' => 'border-blue-400',
            'icon-color'   => 'text-blue-400',
            'text-color'   => 'text-blue-800',
            'icon'         => 'info-circle',
        ],
        'success' => [
            'bg-color'     => 'bg-green-100',
            'border-color' => 'border-green-400',
            'icon-color'   => 'text-green-400',
            'text-color'   => 'text-green-800',
            'icon'         => 'check-circle',
        ],
        'warning' => [
            'bg-color'     => 'bg-yellow-100',
            'border-color' => 'border-yellow-400',
            'icon-color'   => 'text-yellow-400',
            'text-color'   => 'text-yellow-800',
            'icon'         => 'alert',
        ],
        'error' => [
            'bg-color'     => 'bg-red-100',
            'border-color' => 'border-red-400',
            'icon-color'   => 'text-red-400',
            'text-color'   => 'text-red-800',
            'icon'         => 'x-circle',
        ],
        'notice' => [
            'isNotice' => true,
        ],
        'successOverlay' => [
            'isSuccessOverlay' => true,
        ],
        'overlay' => [
            'overly-bg-color' => 'bg-gray-500',
            'overlay-bg-opacity' => 'opacity-75',

            'title-text-color' => 'text-primary-900',

            'body-text-color' => 'text-primary-500',

            'button-border-color' => 'border-transparent',
            'button-bg-color' => 'bg-primary-500',
            'button-text-color' => 'text-white',

            'button-hover-bg-color' => 'hover:bg-primary-700',
            'button-hover-text-color' => 'hover:text-white',
            'button-focus-ring-color' => 'focus:ring-primary-500',

            'button-extra-classes' => '',

            'button-text' => 'Close',
        ],
    ],
];
