import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
                'resources/assets/admin/plugins/select2/css/select2.css',
                'resources/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',
                'resources/assets/admin/css/adminlte.css',
                'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',
                'resources/assets/admin/plugins/select2/js/select2.full.js',
                'resources/assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.js',
                'resources/assets/admin/js/adminlte.js',
                'resources/assets/admin/js/demo.js',
            ],
            refresh: true,
        }),
    ],
});
