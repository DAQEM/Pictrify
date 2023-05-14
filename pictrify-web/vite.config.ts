import { sveltekit } from '@sveltejs/kit/vite';
import dns from 'dns';
import { defineConfig } from 'vitest/config';

dns.setDefaultResultOrder('verbatim');

export default defineConfig({
	plugins: [sveltekit()],
	test: {
		include: ['src/**/*.{test,spec}.{js,ts}']
	},
	server: {
		port: 3000,
		strictPort: false
	},
	preview: {
		port: 4173,
		strictPort: false
	}
});
