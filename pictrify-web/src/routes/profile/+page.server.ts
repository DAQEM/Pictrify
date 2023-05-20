import { redirect } from "@sveltejs/kit";
import type { PageServerLoad } from "./$types";

export const load: PageServerLoad = async ({ locals }) => {
    if (locals.isAuthenticated) {
        throw redirect(302, `/creator/${locals.creator?.getUsername()}`);
    }
    throw redirect(302, "/auth/login");
};