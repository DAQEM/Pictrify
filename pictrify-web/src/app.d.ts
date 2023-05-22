// See https://kit.svelte.dev/docs/types#app

import type { Creator } from "$lib/types/creator";

// for information about these interfaces
declare global {
	namespace App {
		// interface Error {}
		interface Locals {
			viewer: Creator;
			isAuthenticated: boolean;
		}
		// interface PageData {}
		// interface Platform {}
	}
}

export { };
