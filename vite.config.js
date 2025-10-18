import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Si necesitas especificar el 'outDir', hazlo aquí, pero el plugin ya usa 'public/build' por defecto.
    // Si lo dejas simple, es mejor.
});