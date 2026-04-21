import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // 1. Add this import
import path from 'path';

export default defineConfig({
    plugins: [
        tailwindcss(), // 2. Add the plugin here
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // ... keep your resolve/alias section as is
});