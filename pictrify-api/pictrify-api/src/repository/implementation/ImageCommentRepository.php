<?php

namespace Pictrify\Repository;

use MongoDB\Collection;
use Pictrify\IImageCommentRepository;

class ImageCommentRepository implements IImageCommentRepository
{
    private Collection $imageCommentCollection;

    public function __construct()
    {
        $this->imageCommentCollection = (new DatabaseHelper())->getImageCommentCollection();
    }

    public function getAllImageComments(): array
    {
        return $this->imageCommentCollection->find()->toArray();
    }

    public function getImageCommentById($id): ?array
    {
        return (array)$this->imageCommentCollection->findOne(["_id" => $id]);
    }

    public function getImageCommentsByImageId($imageId): ?array
    {
        return $this->imageCommentCollection->find(["image_id" => $imageId])->toArray();
    }

    public function getImageCommentsByCreatorId($creatorId): ?array
    {
        return $this->imageCommentCollection->find(["creator_id" => $creatorId])->toArray();
    }

    public function createImageComment($id, $imageId, $creatorId, $text, $createDate): bool
    {
        return $this->imageCommentCollection->insertOne([
                "_id" => $id,
                "image_id" => $imageId,
                "creator_id" => $creatorId,
                "text" => $text,
                "created_at" => $createDate
            ])->getInsertedCount() > 0;
    }

    public function updateImageComment($id, $text, $editDate): bool
    {
        return $this->imageCommentCollection->updateOne(
                ["_id" => $id],
                [
                    '$set' => [
                        "text" => $text,
                        "edited_at" => $editDate
                    ]
                ]
            )->getModifiedCount() > 0;
    }

    public function deleteImageComment($id): bool
    {
        return $this->imageCommentCollection->deleteOne(["_id" => $id])->getDeletedCount() > 0;
    }
}