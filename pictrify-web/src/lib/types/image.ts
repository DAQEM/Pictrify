import { Guid } from "./guid";

export class Image {
    private id: Guid;
    private title: string;
    private description: string;
    private caption: string;
    private date: Date;
    private url: string;
    private location: GeolocationCoordinates;

    constructor(
        id: Guid = Guid.EMPTY_GUID,
        title: string = "",
        description: string = "",
        caption: string = "",
        date: Date = new Date(),
        url: string = "",
        location: GeolocationCoordinates = new GeolocationCoordinates()
    ) {
        this.id = id;
        this.title = title;
        this.description = description;
        this.caption = caption;
        this.date = date;
        this.url = url;
        this.location = location;
    }
}