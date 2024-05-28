import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        container: {
            center: true,
        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dark: '#1F2937',
                light: '#F9FAFB',
                active: '#a90a0a'
            },
            keyframes: {
                'shake-x': {
                    '16.65%': {transform: 'translateX(8px)'},
                    '33.3%': {transform: 'translateX(-6px)'},
                    '49.95%': {transform: 'translateX(4px)'},
                    '66.6%': {transform: 'translateX(-2px)'},
                    '83.25%': {transform: 'translateX(1px)'},
                    '100%': {transform: 'translateX(0px)'},
                }
            },
            animation:{
                'shake-x': 'shake-x 1s ease-in-out'
            }
        },
    },

    plugins: [forms, import('flowbite/plugin')],
};
