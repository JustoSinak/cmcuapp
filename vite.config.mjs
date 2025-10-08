import { defineConfig } from 'vite';
import path from 'path';
import vue2Plugin from '@vitejs/plugin-vue2';
import laravelPlugin from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravelPlugin({
            input: [
                'resources/assets/js/app.js',
                'resources/assets/js/all.js',
                'resources/assets/js/typehead.js',   
                'resources/assets/sass/app.scss',
                'resources/assets/css/all.scss',
            ],
            refresh: true,
        }),
        vue2Plugin(),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', 'axios', 'lodash'],
                    bootstrap: ['bootstrap', 'jquery'],
                    charts: ['chart.js'],
                },
            },
        },
        chunkSizeWarningLimit: 1000,
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
    },
    server: {
        host: true,
        hmr: {
            host: 'localhost',
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(process.cwd(), 'resources/assets/js'),
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        },
    },
    optimizeDeps: {
        include: ['vue', 'axios', 'lodash', 'bootstrap', 'jquery'],
    },
});


