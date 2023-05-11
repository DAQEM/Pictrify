import { error } from "@sveltejs/kit";
import type { PageServerLoad } from "./$types";

export const load: PageServerLoad = async ({ fetch, params }) => {
    const res = await fetch(`http://localhost:8393/api/creator/${params.id}`);
    const creator = await res.json();

    if (!res.ok) {
        throw error(404, 'Not found');
    }

    return {
        creator
    };
};