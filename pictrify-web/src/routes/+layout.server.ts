import type { LayoutServerLoad } from "./$types";

export const load: LayoutServerLoad = async ({ locals }) => {
    return {
        creator: {
            id: locals.creator?.getId(),
            username: locals.creator?.getUsername(),
            email: locals.creator?.getEmail(),
        },
        isAuthenticated: locals.isAuthenticated,
    };
}