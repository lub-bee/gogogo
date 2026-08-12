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
                // GoGoGo accent palette
                'gogo-blue': '#b7d7fc',
                'gogo-pink': '#fbcfe8',   // pink-200 equivalent
                'gogo-yellow': '#fef9c3', // yellow-100 equivalent
            },
            letterSpacing: {
                'poster': '-0.12em',
                'tight-poster': '-0.08em',
                'btn': '-0.11em',
            },
            fontSize: {
                'hero': ['10rem', { lineHeight: '9rem' }],
                'hero-sm': ['5rem', { lineHeight: '6rem' }],
                'hero-xs': ['4rem', { lineHeight: '2.7rem' }],
                'section': ['7rem', { lineHeight: '6rem' }],
                'section-sm': ['4.5rem', { lineHeight: '3rem' }],
                'section-xs': ['3rem', { lineHeight: '2rem' }],
                'nav-lg': ['7rem', { lineHeight: '4.5rem' }],
                'nav-sm': ['3.5rem', { lineHeight: '2.3rem' }],
            },
            transitionDuration: {
                '250': '250ms',
                '350': '350ms',
                '400': '400ms',
            },
        },
    },

    plugins: [forms],
};
