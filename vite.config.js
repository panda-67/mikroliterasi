import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import { bunny } from "laravel-vite-plugin/fonts";
import tailwindcss from "@tailwindcss/vite";
import path from "path";

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), "");
    const isProduction = env.APP_ENV === "production";

    return {
        plugins: [
            laravel({
                input: ["resources/css/app.css", "resources/js/app.js"],
                refresh: true,
                fonts: [
                    bunny("Source Sans 3", {
                        weights: [400, 500, 600, 700],
                    }),
                ],
            }),
            tailwindcss(),
        ],

        build: {
            outDir: isProduction ? path.resolve(process.cwd(), "../public_html/build") : "public/build",
            emptyOutDir: true,
        },

        server: {
            watch: {
                ignored: ["**/storage/framework/views/**"],
            },
        },
    };
});
