import type { User } from '@auth0/auth0-spa-js';
import { writable } from 'svelte/store';

export const isAuthenticated = writable(false);
export const user: User = writable({});
export const popupOpen = writable(false);
export const error = writable();
