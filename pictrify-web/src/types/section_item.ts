import { Guid } from "./guid";
import { Image } from "./image";

export class SectionItem {
    private id: Guid;
    private order: number;
    private rotation: number;

    private image: Image;

    constructor(
        id: Guid = Guid.EMPTY_GUID,
        order: number = 0,
        rotation: number = 0,
        image: Image = new Image()
    ) {
        this.id = id;
        this.order = order;
        this.rotation = rotation;
        this.image = image;
    }
}