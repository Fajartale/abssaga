import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './node_modules/flowbite/**/*.js' // PENTING: Agar JS Flowbite terdeteksi
    ],

    theme: {
        extend: {
            fontFamily: {
                // Font utama aplikasi (Figtree)
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                
                // Font khusus untuk nuansa Brutalism / Naskah (Courier Prime)
                // Pastikan font ini sudah di-load di layouts/public.blade.php
                mono: ['Courier Prime', ...defaultTheme.fontFamily.mono],
            },

            // Custom Shadow untuk efek "Brutalism" (Bayangan tajam hitam pekat)
            boxShadow: {
                'brutal': '4px 4px 0px 0px rgba(0,0,0,1)',
            },
            
            // Custom Color (Opsional, jika ingin menambah warna spesifik)
            colors: {
                'brutal-yellow': '#facc15', // Kuning terang
                'brutal-pink': '#f472b6',   // Pink
                'brutal-lime': '#a3e635',   // Hijau Lime
            }
        },
    },

    plugins: [
        forms,
        typography, // PENTING: Untuk merapikan hasil tulisan dari Trix Editor
        require('flowbite/plugin') // PENTING: Untuk komponen UI Flowbite
    ],
};