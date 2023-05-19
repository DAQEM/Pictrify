import { Guid } from "./guid";

export class Comment {
    private id: Guid;
    private text: string;
    private post_date: Date;
    private edit_date: Date;

    constructor(
        id: Guid = Guid.EMPTY_GUID,
        text: string = "",
        post_date: Date = new Date(),
        edit_date: Date = new Date()
    ) {
        this.id = id;
        this.text = text;
        this.post_date = post_date;
        this.edit_date = edit_date;
    }
}