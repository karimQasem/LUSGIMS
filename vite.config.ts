import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import * as path from "path";
export default defineConfig({
    resolve: {
        alias: {
            ziggy: path.resolve("vendor/tightenco/ziggy/dist/vue.m"),
        },
    },

    optimizeDeps: {
        include: ["ziggy"],
    },
    plugins: [
        laravel({
            input: "resources/js/app.ts",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
