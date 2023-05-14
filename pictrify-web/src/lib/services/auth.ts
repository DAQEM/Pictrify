import config from '$lib/config/auth_config';
import { isAuthenticated, popupOpen, user } from '$lib/stores/auth';
import { Auth0Client, createAuth0Client } from '@auth0/auth0-spa-js';

async function createClient() {
	return await createAuth0Client(config);
}

async function loginWithPopup(client: Auth0Client) {
	popupOpen.set(true);
	try {
		await client.loginWithPopup(config);

		user.set(await client.getUser());
		isAuthenticated.set(true);
	} catch (e) {
		console.error(e);
	} finally {
		popupOpen.set(false);
	}
}

function logout(client: Auth0Client) {
	return client.logout();
}

const auth = {
	createClient,
	loginWithPopup,
	logout
};

export default auth;
