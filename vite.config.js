import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), "");

    return {
        plugins: [
            laravel({
                input: ["resources/css/app.css", "resources/js/app.js"],
                refresh: true,
            }),
        ],
        define: {
            "import.meta.env": {
                VITE_PUSHER_APP_KEY: env.VITE_PUSHER_APP_KEY,
                VITE_PUSHER_APP_CLUSTER: env.VITE_PUSHER_APP_CLUSTER,
            },
        },
    };
});
