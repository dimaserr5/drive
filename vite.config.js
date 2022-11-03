import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/bootstrap/css/bootstrap.css',
                'resources/css/style.css',
                'resources/js/app.js',
                'resources/bootstrap/js/bootstrap.bundle.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: 'localhost'
        }
    }
});
