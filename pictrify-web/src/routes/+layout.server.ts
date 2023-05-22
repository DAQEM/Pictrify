import type { LayoutServerLoad } from "./$types";

export const load: LayoutServerLoad = async ({ locals }) => {
    return {
        viewer: {
            id: locals.viewer?.getId(),
            username: locals.viewer?.getUsername(),
            email: locals.viewer?.getEmail(),
        },
        isAuthenticated: locals.isAuthenticated,
    };
}