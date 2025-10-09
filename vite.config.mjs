import { defineConfig } from 'vite';
import path from 'path';
import vue from '@vitejs/plugin-vue';
import laravelPlugin from 'laravel-vite-plugin';

export default defineConfig({
    logLevel: 'error',
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
        vue({
            template: {
                compilerOptions: {
                    compatConfig: {
                        MODE: 2 // Vue 2 compatibility mode
                    }
                }
            }
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['legacy-js-api', 'import', 'global-builtin', 'color-functions'],
                additionalData: `@import "bootstrap/scss/functions"; @import "bootstrap/scss/variables"; @import "bootstrap/scss/mixins";`
            }
        }
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', '@vue/compat', 'axios', 'lodash'],
                    bootstrap: ['bootstrap', 'jquery', '@popperjs/core'],
                },
            },
            onwarn(warning, warn) {
                if (warning.code === 'SOURCEMAP_ERROR') return;
                warn(warning);
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
            'vue': '@vue/compat'
        },
    },
    optimizeDeps: {
        include: ['vue', '@vue/compat', 'axios', 'lodash', 'bootstrap', 'jquery'],
    },
});
