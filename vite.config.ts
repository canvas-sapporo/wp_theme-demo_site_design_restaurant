import path from 'path';
import { fileURLToPath } from 'url';
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
  plugins: [tailwindcss()],
  build: {
    outDir: path.resolve(__dirname, 'dist'),
    emptyOutDir: true,
    cssCodeSplit: false,
    rollupOptions: {
      input: path.resolve(__dirname, 'src/main.ts'),
      output: {
        entryFileNames: 'js/theme.js',
        assetFileNames: (assetInfo) => {
          const names = assetInfo.names ?? [];
          const base = names[0] ?? '';
          if (base.endsWith('.css')) {
            return 'css/app.css';
          }
          return '[name][extname]';
        },
      },
    },
  },
});
