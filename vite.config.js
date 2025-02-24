import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.jsx',
                'resources/js/boostrap.jsx',
            ],
            refresh: true,
        }),
        react(),
    ],
    css: {
        modules: {
            generateScopedName: '[name]__[local]___[hash:base64:5]',
        },
    },

    // server: {
    //     host: '192.168.0.152',
    //     port: 5173,
    //     cors: true, // Mở CORS
    //     watch: {
    //         usePolling: true,
    //     },
    // },
});
