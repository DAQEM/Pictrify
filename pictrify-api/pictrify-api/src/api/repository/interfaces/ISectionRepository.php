<?php

namespace Pictrify\interfaces;

interface ISectionRepository
{
    public function getAllSections(): array;

    public function getSectionById(string $id): array;

    public function getAllSectionsByPhotoAlbumId(string $photoAlbumId): array;

    public function getAllSectionsByCreatorId(string $creatorId): array;

    public function createSection($id, $photoAlbumId, $title, $description, $sectionType, $creationDate): bool;

    public function updateSection($id, $photoAlbumId, $title, $description, $sectionType, $editDate): bool;

    public function deleteSection($id): bool;
}