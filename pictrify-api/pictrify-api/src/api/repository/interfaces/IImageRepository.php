<?php

namespace Pictrify\interfaces;

interface IImageRepository
{
    public function getAllImages(): array;

    public function getImageById(string $id): array;

    public function getImagesByCreatorId(string $creatorId): array;

    public function getImagesByPhotoAlbumId(string $photoAlbumId): array;

    public function getImagesBySectionId(string $sectionId): array;

    public function getImagesBySectionItemId(string $sectionItemId): array;

    public function createImage($id, $sectionItemId, $title, $description, $caption, $date, $url, $creationDate): bool;

    public function updateImage($id, $sectionItemId, $title, $description, $caption, $date, $url, $editDate): bool;

    public function deleteImage($id): bool;
}