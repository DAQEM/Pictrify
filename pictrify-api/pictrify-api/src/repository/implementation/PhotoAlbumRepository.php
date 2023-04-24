<?php

namespace Pictrify\Repository;

use MongoDB\Collection;
use Pictrify\interfaces\IPhotoAlbumRepository;

class PhotoAlbumRepository implements IPhotoAlbumRepository
{
    private Collection $photoAlbumCollection;

    public function __construct()
    {
        $this->photoAlbumCollection = (new DatabaseHelper())->getPhotoAlbumCollection();
    }

    public function getAllPhotoAlbums(): array
    {
        return $this->photoAlbumCollection->find()->toArray();
    }

    public function getAllPhotoAlbumsByCreatorId($creatorId): array
    {
        return $this->photoAlbumCollection->find(["creator_id" => $creatorId])->toArray();
    }

    public function getPhotoAlbumById($id): array
    {
        return (array)$this->photoAlbumCollection->findOne(["_id" => $id]);
    }

    public function getPhotoAlbumBySlug($slug): array
    {
        return (array)$this->photoAlbumCollection->findOne(["slug" => $slug]);
    }

    public function getPhotoAlbumByCreatorIdAndSlug(string $creatorId, string $slug): array
    {
        return (array)$this->photoAlbumCollection->findOne(["creator_id" => $creatorId, "slug" => $slug]);
    }

    public function createPhotoAlbum($id, $creatorId, $name, $description, $slug, $creationDate): bool
    {
        return $this->photoAlbumCollection->insertOne([
                "_id" => $id,
                "creator_id" => $creatorId,
                "name" => $name,
                "description" => $description,
                "slug" => $slug,
                "created_at" => $creationDate
            ])->getInsertedCount() > 0;
    }

    public function updatePhotoAlbum($id, $creatorId, $name, $description, $slug, $editDate): bool
    {
        return $this->photoAlbumCollection->updateOne(
                ["_id" => $id],
                [
                    '$set' => [
                        "creator_id" => $creatorId,
                        "name" => $name,
                        "description" => $description,
                        "slug" => $slug,
                        "edited_at" => $editDate
                    ]
                ]
            )->getModifiedCount() > 0;
    }

    public function deletePhotoAlbum($id): bool
    {
        return $this->photoAlbumCollection->deleteOne(["_id" => $id])->getDeletedCount() > 0;
    }
}