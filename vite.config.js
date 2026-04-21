import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // 1. Import path

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            // 2. Add this alias to point to the node_modules folder
            'bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        },
    },
});
