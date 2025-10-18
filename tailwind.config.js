import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
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
            animation: {
                'nebula-pulse': 'pulse 6s ease-in-out infinite alternate',
                'pulse-slow': 'pulse 5s ease-in-out infinite',
                'pulse-fast': 'pulse 2s ease-in-out infinite',
                'cosmic-drift': 'drift 15s ease-in-out infinite alternate',
                'cosmic-rays': 'spin 20s linear infinite',
                'star-twinkle': 'twinkle 4s ease-in-out infinite alternate',
                'stardust': 'float 8s ease-in-out infinite alternate',
                'float-particle': 'floatUp 5s ease-in-out infinite alternate',
                'float-particle-slow': 'floatUp 8s ease-in-out infinite alternate',
                'float-particle-micro': 'floatUp 4s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite alternate',
                'float-particle-tiny': 'floatUpShort 3s ease-in-out infinite alternate',
                'sparkle': 'sparkle 3s ease-in-out infinite alternate',
            },
            keyframes: {
                pulse: {
                    '0%, 100%': { opacity: 1 },
                    '50%': { opacity: 0.6 },
                },
                drift: {
                    '0%': { transform: 'translateY(0) translateX(0) rotate(0)' },
                    '100%': { transform: 'translateY(-15px) translateX(10px) rotate(5deg)' },
                },
                twinkle: {
                    '0%': { opacity: 0.3, transform: 'scale(0.8)' },
                    '100%': { opacity: 1, transform: 'scale(1.2)' },
                },
                float: {
                    '0%': { transform: 'translateY(0)' },
                    '100%': { transform: 'translateY(-30px)' },
                },
                floatUp: {
                    '0%': { transform: 'translateY(0)', opacity: 0.5 },
                    '100%': { transform: 'translateY(-50px)', opacity: 0.9 },
                },
                floatUpShort: {
                    '0%': { transform: 'translateY(0)', opacity: 0.4 },
                    '100%': { transform: 'translateY(-20px)', opacity: 0.8 },
                },
                sparkle: {
                    '0%': { opacity: 0.2, transform: 'scale(0.6)' },
                    '50%': { opacity: 0.9, transform: 'scale(1.1)' },
                    '100%': { opacity: 0.2, transform: 'scale(0.7)' },
                },
            },
        },
    },

    plugins: [forms],
};
