import { error } from "@sveltejs/kit";
import type { PageServerLoad } from "./$types";

export const load: PageServerLoad = async ({ fetch, params }) => {
    const creatorResonse = await fetch(`http://localhost:8393/api/creator/username/${params.username}`);
    const creator = await creatorResonse.json();

    if (!creatorResonse.ok) {
        throw error(404, 'Not found');
    }

    const creatorId: string = creator._id;
    const photoAlbumsResponse = await fetch(`http://localhost:8393/api/photo-album/creator/${creatorId}`);
    const photoAlbums = await photoAlbumsResponse.json();

    if (!photoAlbumsResponse.ok) {
        throw error(404, 'Not found');
    }

    return {
        creator,
        photoAlbums
    };
};