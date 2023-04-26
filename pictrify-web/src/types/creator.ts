import type { Comment } from "./comment";
import { Guid } from "./guid";
import type { PhotoAlbum } from "./photo_album";

export class Creator {
    private id: Guid;
    private username: string;
    private email: string;
    private created_at: Date;

    private photo_albums : PhotoAlbum[];
    private comments: Comment[];
    private liked_photo_albums: PhotoAlbum[];

    constructor(
        id: Guid = Guid.EMPTY_GUID,
        username: string = "",
        email: string = "",
        created_at: Date = new Date(),
        photo_albums: PhotoAlbum[] = [],
        comments: Comment[] = [],
        liked_photo_albums: PhotoAlbum[] = []
    ) {
        this.id = id;
        this.username = username;
        this.email = email;
        this.created_at = created_at;
        this.photo_albums = photo_albums;
        this.comments = comments;
        this.liked_photo_albums = liked_photo_albums;
    }

    public static fromJson(json: any): Creator {
        return new Creator(
            new Guid(json._id),
            json.username,
            json.email,
            new Date(json.created_at),
            json.photo_albums,
            json.comments,
            json.liked_photo_albums
        );
    }

    public getId(): Guid {
        return this.id;
      }
    
      public getUsername(): string {
        return this.username;
      }
    
      public getEmail(): string {
        return this.email;
      }
    
      public getCreatedAt(): Date {
        return this.created_at;
      }
}