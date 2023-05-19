import { Guid } from "./guid";
import type { SectionItem } from "./section_item";
import { SectionType } from "./section_type";

export class Section {
    private id: Guid;
    private title: string;
    private description: string;
    private type: SectionType;

    private sectionItems: SectionItem[];

    constructor(
        id: Guid = Guid.EMPTY_GUID,
        title: string = "",
        description: string = "",
        type: SectionType = SectionType.EMPTY,
        sectionItems: SectionItem[] = []
    ) {
        this.id = id;
        this.title = title;
        this.description = description;
        this.type = type;
        this.sectionItems = sectionItems;
    }
}