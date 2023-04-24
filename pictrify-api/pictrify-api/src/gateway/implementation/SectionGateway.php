<?php

namespace Pictrify\Gateway;

use MongoDB\Collection;
use Pictrify\interfaces\ISectionGateway;

class SectionGateway implements ISectionGateway
{
    private Collection $sectionCollection;

    public function __construct()
    {
        $this->sectionCollection = (new DatabaseHelper())->getSectionCollection();
    }

    public function getAllSections(): array
    {
        return $this->sectionCollection->find()->toArray();
    }

    public function getSectionById(string $id): array
    {
        return $this->sectionCollection->findOne(['_id' => $id]);
    }

    public function getSectionsByCreatorId(string $creatorId): array
    {
        return $this->sectionCollection->find(['creatorId' => $creatorId])->toArray();
    }

    public function getSectionsByPhotoAlbumId(string $photoAlbumId): array
    {
        return $this->sectionCollection->find(['photoAlbumId' => $photoAlbumId])->toArray();
    }

    public function createSection($id, $photoAlbumId, $title, $description, $sectionType, $creationDate): bool
    {
        return $this->sectionCollection->insertOne([
                '_id' => $id,
                'photoAlbumId' => $photoAlbumId,
                'title' => $title,
                'description' => $description,
                'sectionType' => $sectionType,
                'creationDate' => $creationDate,
                'editDate' => null,
            ])->getInsertedCount() > 0;
    }

    public function updateSection($id, $photoAlbumId, $title, $description, $sectionType, $editDate): bool
    {
        return $this->sectionCollection->updateOne(
                ['_id' => $id],
                [
                    '$set' => [
                        'photoAlbumId' => $photoAlbumId,
                        'title' => $title,
                        'description' => $description,
                        'sectionType' => $sectionType,
                        'editDate' => $editDate,
                    ]
                ]
            )->getModifiedCount() > 0;
    }

    public function deleteSection($id): bool
    {
        return $this->sectionCollection->deleteOne(['_id' => $id])->getDeletedCount() > 0;
    }
}