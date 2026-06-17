import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  // Base path for assets in production
  base: './',

  build: {
    // Output to theme's assets/dist folder
    outDir: 'wp-content/themes/acf-bootstrap-vip-starter/assets/dist',
    emptyOutDir: true,

    rollupOptions: {
      input: {
        main: resolve(__dirname, 'wp-content/themes/acf-bootstrap-vip-starter/src/main.js'),
      },
      output: {
        // Clean filenames without hashes — WordPress enqueue needs predictable names
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith('.css')) {
            return 'css/[name][extname]';
          }
          return 'assets/[name][extname]';
        },
      },
    },
  },

  server: {
    port: 3000,
  },
});
