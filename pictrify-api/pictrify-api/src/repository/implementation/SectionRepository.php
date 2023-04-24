<?php

namespace Pictrify\Repository;

use MongoDB\Collection;
use Pictrify\interfaces\ISectionRepository;

class SectionRepository implements ISectionRepository
{
    private Collection $sectionCollection;
    private PhotoAlbumRepository $photoAlbumRepository;

    public function __construct()
    {
        $this->sectionCollection = (new DatabaseHelper())->getSectionCollection();
        $this->photoAlbumRepository = new PhotoAlbumRepository();
    }

    public function getAllSections(): array
    {
        return $this->sectionCollection->find()->toArray();
    }

    public function getSectionById(string $id): array
    {
        return (array)$this->sectionCollection->findOne(['_id' => $id]);
    }

    public function getAllSectionsByPhotoAlbumId(string $photoAlbumId): array
    {
        return $this->sectionCollection->find(['photoAlbumId' => $photoAlbumId])->toArray();
    }

    public function getAllSectionsByCreatorId(string $creatorId): array
    {
        $sections = array();
        $photoAlbums = $this->photoAlbumRepository->getAllPhotoAlbumsByCreatorId($creatorId);

        foreach ($photoAlbums as $photoAlbum) {
            $sections = array_merge($sections, $this->getAllSectionsByPhotoAlbumId($photoAlbum['_id']));
        }

        return $sections;
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