import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';

export default defineConfig({
    plugins: [
        laravel({
            // Keep current entry paths from Mix
            input: [
                'resources/assets/js/app.js',
                'resources/assets/sass/app.scss',
            ],
            refresh: true,
        }),
        vue(),
    ],
    // Allow using legacy folder structure under resources/assets
    resolve: {
        alias: {
            '@': '/resources/assets/js',
        },
    },
});

import { defineConfig } from 'vite';
import legacy from '@vitejs/plugin-legacy';
import vue from '@vitejs/plugin-vue2';
import path from 'path';

export default defineConfig(({ command, mode }) => {
    return {
        base: '/',
        plugins: [
            vue(),
            legacy({
                targets: ['defaults', 'not IE 11'],
            })
        ],
        build: {
            m