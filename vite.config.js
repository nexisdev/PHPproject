import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

import { NodeGlobalsPolyfillPlugin } from "@esbuild-plugins/node-globals-polyfill";
import inject from "@rollup/plugin-inject";
import nodePolyfills from "rollup-plugin-polyfill-node";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/theme.js",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            // "@": "/src",
            web3: "web3/dist/web3.min.js",
        },
    },
    build: {
        rollupOptions: {
            plugins: [
                nodePolyfills(),
                inject({
                    util: "util/",
                }),
            ],
        },
        commonjsOptions: {
            transformMixedEsModules: true,
        },
    },
    optimizeDeps: {
        esbuildOptions: {
            // Node.js global to browser globalThis
            define: {
                global: "globalThis",
            },
            // Enable esbuild polyfill plugins
            plugins: [
                NodeGlobalsPolyfillPlugin({
                    buffer: true,
                }),
            ],
        },
    },
});
