import { redirect } from "@sveltejs/kit";
import type { Actions, PageServerLoad } from "./$types";

export const actions: Actions = {
    default: async ({ cookies }) => {
        cookies.set("token", "", {
            maxAge: 0,
            path: "/",
            sameSite: "strict",
            secure: true,
        });
    }
};

export const load: PageServerLoad = async () => {
    throw redirect(302, "/");
};
