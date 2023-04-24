<?php

namespace Pictrify\interfaces;

interface ISectionItemGateway
{
    public function getAllSectionItems(): array;

    public function getSectionItemById(string $id): array;

    public function getAllSectionItemsBySectionId(string $sectionId): array;

    public function createSectionItem($id, $sectionId, $order, $rotation, $creationDate): bool;

    public function updateSectionItem($id, $sectionId, $order, $rotation, $editDate): bool;

    public function deleteSectionItem($id): bool;
}