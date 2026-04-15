import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    primary: '#182c0c',
                    'primary-light': '#2a3f1f',
                    secondary: '#696761',
                    'secondary-light': '#8b8680',
                    dark: '#342825',
                    'dark-light': '#4a3f38',
                    accent: '#b6a337',
                    'accent-light': '#d4c560',
                    light: '#b9a480',
                    'light-light': '#d4c4a8',
                },
            },
        },
    },

    plugins: [forms],
};
