import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // Safelist dynamic color classes used in Blade loops (Tailwind purges assembled strings)
    safelist: [
        { pattern: /^bg-(indigo|purple|blue|green|orange|pink|yellow)-(100|200|400)$/ },
        { pattern: /^text-(indigo|purple|blue|green|orange|pink|yellow)-(500|600|700)$/ },
        { pattern: /^border-(indigo|purple|blue|green|orange|pink|yellow)-(200|300)$/ },
    ],

    theme: {
        extend: {
            fontFamily: {
                // Replace Figtree with project fonts; fallback to system sans
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                display: ['Baloo 2', 'cursive'],
            },
        },
    },

    plugins: [forms],
};
