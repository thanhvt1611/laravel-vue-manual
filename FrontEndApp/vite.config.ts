import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default ({ mode }) => {
  // check if development
  const isDevelopment = mode === "development";

  return defineConfig({
    server: {
      port: 3000,
    },
    build: {
      // the built files will be added here
      outDir: "./../public/app",
    },
    // also going to change base base on mode
    base: isDevelopment ? "/" : "/app/",
    plugins: [vue()],
  });
};
