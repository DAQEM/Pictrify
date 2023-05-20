import type { Handle } from "@sveltejs/kit";
import constants from "$lib/constants";
import { Creator } from "$lib/types/creator";

export const handle: Handle = async ({ event, resolve }) => {
    const token = event.cookies.get("token");

    if (token) {
        const verifyResponse = await fetch(`${constants.AUTH_URL}/auth/verify`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ token }),
        });

        if (verifyResponse.ok) {
            const { user } = await verifyResponse.json();
            event.locals.creator = new Creator(user.id, user.username, user.email);
            event.locals.isAuthenticated = true;
        }
    }

    return await resolve(event);
};