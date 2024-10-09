import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import VueDevTools from 'vite-plugin-vue-devtools'
import path from 'path'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    VueDevTools(),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
  },
  server: {
    host: '0.0.0.0',
    watch: {
      usePolling: true
    },
    hmr: {
      host: 'localhost',
      port: 5173,
    },
    mimeTypes: {
      'application/javascript': ['js'],
      'text/javascript': ['vue'],
      'application/json': ['json']
    },
    optimizeDeps: {
      include: [
        "quill", 
        "quill-image-resize-module"],
    },
    port: 5173
  }
})
