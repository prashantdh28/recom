import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import legacy from '@vitejs/plugin-legacy'; // Correct legacy plugin import

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.scss',
        'resources/js/app.js',
        'resources/js/bootstrap.js',
        'resources/js/datatable-tailwind.js',
        'resources/js/account-config/index.js',
        'resources/js/gtin-code/index.js',
        'resources/js/product-list/index.js',
      ],
      refresh: true,
    }),
    tailwindcss(),
    legacy({
      targets: ['defaults', 'not IE 11'], // Adjust browser targets as needed
      additionalLegacyPolyfills: ['regenerator-runtime/runtime'], // Optional polyfills
    }),
  ],
  optimizeDeps: {
    include: ['datatables.net', 'jquery'],
  },
});

