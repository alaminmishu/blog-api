import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: "0.0.0.0",
        port: 5173,
        strictPort: true,
        // Defines the origin of the generated asset URLs during development,
        // this must be set to the Vite dev server URL and selected port.
        origin: `${process.env.DDEV_PRIMARY_URL_WITHOUT_PORT}:5173`,
        // Configure CORS securely for the Vite dev server to allow requests
        // from *.ddev.site domains, supports additional hostnames (via regex).
        // If you use another `project_tld`, adjust this value accordingly.
        cors: {
            origin: /https?:\/\/([A-Za-z0-9\-\.]+)?(\.ddev\.site)(?::\d+)?$/,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
