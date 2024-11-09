import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/sass/**/*.scss',
        './config/livewire-flash.php'
    ],

    theme: {
        extend: {
            fontSize: {
                'xxs': '0.55rem',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                'xl': '1rem',
            },
            colors: {
                primary: {
                    DEFAULT: '#424D51',
                    '50': '#9CAAAE',
                    '100': '#91A0A5',
                    '200': '#7A8C93',
                    '300': '#67787E',
                    '400': '#546267',
                    '500': '#424D51',
                    '600': '#293032',
                    '700': '#101213',
                    '800': '#000000',
                    '900': '#000000'
                },
                secondary: {
                    '50': '#F8FBFD',
                    '100': '#E8F1F9',
                    '200': '#C8DEF1',
                    '300': '#A7CAE9',
                    '400': '#87B7E0',
                    '500': '#66A3D8',
                    '600': '#3988CD',
                    '700': '#2A6BA4',
                    '800': '#1E4E77',
                    '900': '#13314B'
                },
                gray: {
                    '750': '#242e3c',
                    '850': '#141b2a',
                    '950': '#0a0e16'
                },
            },
        },
    },

    plugins: [forms, typography],
};
