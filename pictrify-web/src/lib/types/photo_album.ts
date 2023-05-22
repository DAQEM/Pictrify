import type { Creator } from "./creator";
import { Guid } from "./guid";
import type { Section } from "./section";

export class PhotoAlbum {
    private id: Guid;
    private name: string;
    private description: string;
    private slug: string;
    private creation_date: Date;
    private edit_date: Date;

    private sections: Section[];
    private comments: Comment[];
    private likers: Creator[];

    constructor(
        id: Guid = Guid.EMPTY_GUID,
        name: string = "",
        description: string = "",
        slug: string = "",
        creation_date: Date = new Date(),
        edit_date: Date = new Date(),
        sections: Section[] = [],
        comments: Comment[] = [],
        likers: Creator[] = []
    ) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.slug = slug;
        this.creation_date = creation_date;
        this.edit_date = edit_date;
        this.sections = sections;
        this.comments = comments;
        this.likers = likers;
    }

    public getId(): Guid {
        return this.id;
    }

    public getName(): string {
        return this.name;
    }

    public getDescription(): string {
        return this.description;
    }

    public getSlug(): string {
        return this.slug;
    }

    public getCreationDate(): Date {
        return this.creation_date;
    }

    public getEditDate(): Date {
        return this.edit_date;
    }

    public static fromJson(json: any): PhotoAlbum {
        return new PhotoAlbum(
            new Guid(json._id),
            json.name,
            json.description,
            json.slug,
            new Date(json.created_at),
            new Date(json.edit_date),
            json.sections,
            json.comments,
            json.likers
        );
    }
}