<?php

namespace Pictrify\Repository;

use MongoDB\Collection;
use Pictrify\interfaces\IPhotoAlbumCommentRepository;

class PhotoAlbumCommentRepository implements IPhotoAlbumCommentRepository
{
    private Collection $photoAlbumCommentCollection;

    public function __construct()
    {
        $this->photoAlbumCommentCollection = (new DatabaseHelper())->getPhotoAlbumCommentCollection();
    }

    public function getAllPhotoAlbumComments(): array
    {
        return $this->photoAlbumCommentCollection->find()->toArray();
    }

    public function getPhotoAlbumCommentById($id): ?array
    {
        return (array)$this->photoAlbumCommentCollection->findOne(["_id" => $id]);
    }

    public function getPhotoAlbumCommentsByPhotoAlbumId($photoAlbumId): ?array
    {
        return $this->photoAlbumCommentCollection->find(["photo_album_id" => $photoAlbumId])->toArray();
    }

    public function getPhotoAlbumCommentsByCreatorId($creatorId): ?array
    {
        return $this->photoAlbumCommentCollection->find(["creator_id" => $creatorId])->toArray();
    }

    public function createComment($id, $photoAlbumId, $creatorId, $text, $createdDate): bool
    {
        return $this->photoAlbumCommentCollection->insertOne([
                "_id" => $id,
                "photo_album_id" => $photoAlbumId,
                "creator_id" => $creatorId,
                "text" => $text,
                "created_at" => $createdDate
            ])->getInsertedCount() > 0;
    }

    public function updateComment($id, $text, $editDate): bool
    {
        return $this->photoAlbumCommentCollection->updateOne(
                ["_id" => $id],
                [
                    '$set' => [
                        "text" => $text,
                        "edited_at" => $editDate
                    ]
                ]
            )->getModifiedCount() > 0;
    }

    public function deleteComment($id): bool
    {
        return $this->photoAlbumCommentCollection->deleteOne(["_id" => $id])->getDeletedCount() > 0;
    }
}