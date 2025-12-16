// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Courier Prime', ...defaultTheme.fontFamily.sans], // Font monospaced cocok untuk brutalism
            },
            boxShadow: {
                'brutal': '4px 4px 0px 0px rgba(0,0,0,1)', // Shadow tajam khas brutalism
            }
        },
    },
    plugins: [
        require('flowbite/plugin'),
        require('@tailwindcss/typography'), // Untuk styling hasil tulisan novel
    ],
};