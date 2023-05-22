import { fail } from '@sveltejs/kit';
import type { RequestHandler } from './$types';
import constants from '$lib/constants';

export const POST: RequestHandler = async ({ locals, request }) => {
    const options = {
        headers: {
            'Content-Type': 'application/json'
        }
    };

    if (!locals.isAuthenticated) {
        return new Response(JSON.stringify({ success: false, message: 'User is not authenticated' }), options);
    }
    const data = await request.formData();
    const currentUsername: string = locals.viewer?.getUsername();
    const username: string = data.get('username') as string;

    if (username === currentUsername) {
        return new Response(JSON.stringify({ success: false, message: 'Username is the same as the current username' }), options);
    }

    console.log('username', username);

    const response = await fetch(`${constants.AUTH_URL}/auth/change/username`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ old_username: currentUsername, new_username: username })
    });

    console.log('response', response);
    // if (!response.ok) {
    //     const { message } = await response.json();
    //     return new Response(JSON.stringify({ success: false, message }), options);
    // }


    // return new Response(JSON.stringify({ success: true }), options);
    return new Response(JSON.stringify({ success: false, message: 'Not implemented' }), options);
};