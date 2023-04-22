import type { Comment } from "./comment";
import { Guid } from "./guid";
import type { PhotoAlbum } from "./photo_album";

export class Creator {
    private id: Guid;
    private username: string;
    private email: string;
    private join_date: Date;

    private photo_albums : PhotoAlbum[];
    private comments: Comment[];
    private liked_photo_albums: PhotoAlbum[];

    constructor(
        id: Guid = Guid.EMPTY_GUID,
        username: string = "",
        email: string = "",
        join_date: Date = new Date(),
        photo_albums: PhotoAlbum[] = [],
        comments: Comment[] = [],
        liked_photo_albums: PhotoAlbum[] = []
    ) {
        this.id = id;
        this.username = username;
        this.email = email;
        this.join_date = join_date;
        this.photo_albums = photo_albums;
        this.comments = comments;
        this.liked_photo_albums = liked_photo_albums;
    }
}