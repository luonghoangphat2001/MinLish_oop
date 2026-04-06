import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        { pattern: /^bg-(indigo|purple|blue|green|orange|pink|yellow|gray)-(100|200|400)$/ },
        { pattern: /^bg-(red|amber|emerald|blue)-(500|600)$/ },
        { pattern: /^text-(indigo|purple|blue|green|orange|pink|yellow)-(500|600|700)$/ },
        { pattern: /^text-(red|amber|emerald|blue)-700$/ },
        { pattern: /^border-(indigo|purple|blue|green|orange|pink|yellow)-(200|300)$/ },
        { pattern: /^ring-(red|amber|emerald|blue)-300$/, variants: ['focus'] },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                display: ['Baloo 2', 'cursive'],
            },
        },
    },

    plugins: [forms],
};
