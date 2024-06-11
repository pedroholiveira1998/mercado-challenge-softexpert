import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  resolve: {
    alias: [
      { find: '@assets', replacement: '/src/assets' },
      { find: '@components', replacement: '/src/components' },
      { find: '@pages', replacement: '/src/pages' },
      { find: '@lib', replacement: '/src/lib' },
      { find: '@hooks', replacement: '/src/hooks' },
      { find: '@contexts', replacement: '/src/contexts' },
      { find: '@routes', replacement: '/src/routes' },
      { find: '@services', replacement: '/src/services' },
      { find: '@styles', replacement: '/src/styles' },
      { find: '@utils', replacement: '/src/utils' },
      { find: '@constants', replacement: '/src/constants' },
    ],
  },
  server: {
    watch: {
      usePolling: true,
    },
    host: true, // needed for the Docker Container port mapping to work
    // strictPort: true,
    port: 5173, // you can replace this port with any port
  },
  build: {
    rollupOptions: {
      watch: false,
      onwarn(warning, warn) {
        if (warning.code === 'MODULE_LEVEL_DIRECTIVE') {
          return
        }
        warn(warning)
      },
    }
  }
});
