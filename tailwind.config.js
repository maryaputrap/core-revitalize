import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': {
                    light: colors.blue['400'],
                    DEFAULT: colors.blue['700'],
                    dark: colors.blue['900'],
                },
                'secondary': {
                    light: colors.sky['400'],
                    DEFAULT: colors.sky['500'],
                    dark: colors.sky['600'],
                },
                'grayscale': {
                    heading: '#111214',
                    subheading: '#424447',
                    placeholder: '#808080',
                    disabled: '#82878F',
                    surface: '#F5F7FA',
                    line: '#EBEDF0'
                },
                'accent': {
                    yellow: '#EEA805',
                },
            }
        },
    },

    plugins: [forms],
};
