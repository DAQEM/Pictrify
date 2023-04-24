<?php

namespace Pictrify\interfaces;

interface IPhotoAlbumGateway
{
    public function getAllPhotoAlbums(): array;

    public function getAllPhotoAlbumsByCreatorId(string $creatorId): array;

    public function getPhotoAlbumById(string $id): array;

    public function getPhotoAlbumBySlug(string $slug): array;

    public function getPhotoAlbumByCreatorIdAndSlug(string $creatorId, string $slug): array;

    public function createPhotoAlbum($id, $creatorId, $name, $description, $slug, $creationDate): bool;

    public function updatePhotoAlbum($id, $creatorId, $name, $description, $slug, $editDate): bool;

    public function deletePhotoAlbum($id): bool;
}