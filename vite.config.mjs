import { defineConfig } from 'vite';
import path from 'path';
import vue2Plugin from '@vitejs/plugin-vue2';
import laravelPlugin from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravelPlugin({
            input: [
                'resources/assets/js/app.js',
                'resources/assets/sass/app.scss',
                'resources/assets/css/all.scss',
                'resources/assets/js/all.js',
                'resources/assets/js/typehead.js',
            ],
            refresh: true,
        }),
        vue2Plugin(),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
    },
    server: {
        host: true,
        hmr: {
            host: 'localhost',
        },
    },
    resolve: {
        alias: {
            '~': path.resolve(process.cwd(), 'node_modules'),
            '@': path.resolve(process.cwd(), 'resources/assets/js'),
        },
    },
});


