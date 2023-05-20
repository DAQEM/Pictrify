import type { Actions } from './$types';
import constants from '$lib/constants';
import { fail, redirect } from '@sveltejs/kit';

export const actions: Actions = {
    default: async ({ cookies, request }) => {
        const data = await request.formData();
        const username = data.get('username');
        const email = data.get('email');
        const password = data.get('password');

        process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0';
        const response = await fetch(`${constants.AUTH_URL}/auth/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username, email, password })
        });

        if (!response.ok) {
            const { message } = await response.json();
            return fail(400, { username, email, message: message });
        }

        const { token } = await response.json();

        cookies.set('token', token, {
            maxAge: constants.AUTH_TOKEN_EXPIRY_SECONDS,
            path: '/',
            sameSite: 'strict',
            secure: true,
        });

        throw redirect(302, '/');
    },
};