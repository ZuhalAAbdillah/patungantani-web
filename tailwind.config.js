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
        { pattern: /bg-brand-(dark|primary|accent|light)/ },
        { pattern: /text-brand-(dark|primary|accent|light)/ },
        { pattern: /border-brand-(dark|primary|accent|light)/ },
        { pattern: /hover:bg-brand-(dark|primary|accent|light)/ },
        { pattern: /focus:border-brand-(dark|primary|accent|light)/ },
        { pattern: /focus:ring-brand-(dark|primary|accent|light)/ },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    dark: '#1B3C2D',
                    primary: '#1B5E3B',
                    accent: '#4CAF50',
                    light: '#F8FAF9',
                }
            },
        },
    },

    plugins: [forms],
};
