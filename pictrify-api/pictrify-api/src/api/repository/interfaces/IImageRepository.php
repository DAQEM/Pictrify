<?php

namespace Pictrify\interfaces;

interface IImageRepository
{
    public function getAllImages(): array;

    public function getImageById(string $id): array;

    public function getImageBySectionItemId(string $sectionItemId): array;

    public function getAllImagesByCreatorId(string $creatorId): array;

    public function getAllImagesByPhotoAlbumId(string $photoAlbumId): array;

    public function getAllImagesBySectionId(string $sectionId): array;

    public function createImage($id, $sectionItemId, $title, $description, $caption, $date, $url, $creationDate): bool;

    public function updateImage($id, $sectionItemId, $title, $description, $caption, $date, $url, $editDate): bool;

    public function deleteImage($id): bool;
}