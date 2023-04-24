<?php

namespace Pictrify\Repository;

use MongoDB\Collection;
use Pictrify\interfaces\IImageRepository;

class ImageRepository implements IImageRepository
{
    private Collection $imageCollection;
    private SectionItemRepository $sectionItemRepository;

    public function __construct()
    {
        $this->imageCollection = (new DatabaseHelper())->getImagesCollection();
        $this->sectionItemRepository = new SectionItemRepository();
    }

    public function getAllImages(): array
    {
        return $this->imageCollection->find()->toArray();
    }

    public function getImageById(string $id): array
    {
        return (array)$this->imageCollection->findOne(['_id' => $id]);
    }

    public function getImageBySectionItemId(string $sectionItemId): array
    {
        return $this->imageCollection->find(['sectionItemId' => $sectionItemId])->toArray();
    }

    public function getAllImagesByCreatorId(string $creatorId): array
    {
        $images = array();
        $sectionItems = $this->sectionItemRepository->getAllSectionItemsByCreatorId($creatorId);

        foreach ($sectionItems as $sectionItem) {
            $images = array_merge($images, $this->getImageBySectionItemId($sectionItem['_id']));
        }

        return $images;
    }

    public function getAllImagesByPhotoAlbumId(string $photoAlbumId): array
    {
        $images = array();
        $sectionItems = $this->sectionItemRepository->getAllSectionItemsByPhotoAlbumId($photoAlbumId);

        foreach ($sectionItems as $sectionItem) {
            $images = array_merge($images, $this->getImageBySectionItemId($sectionItem['_id']));
        }

        return $images;
    }

    public function getAllImagesBySectionId(string $sectionId): array
    {
        $images = array();
        $sectionItems = $this->sectionItemRepository->getAllSectionItemsBySectionId($sectionId);

        foreach ($sectionItems as $sectionItem) {
            $images = array_merge($images, $this->getImageBySectionItemId($sectionItem['_id']));
        }

        return $images;
    }

    public function createImage($id, $sectionItemId, $title, $description, $caption, $date, $url, $creationDate): bool
    {
        return $this->imageCollection->insertOne([
                '_id' => $id,
                'sectionItemId' => $sectionItemId,
                'title' => $title,
                'description' => $description,
                'caption' => $caption,
                'date' => $date,
                'url' => $url,
                'creationDate' => $creationDate
            ])->getInsertedCount() > 0;
    }

    public function updateImage($id, $sectionItemId, $title, $description, $caption, $date, $url, $editDate): bool
    {
        return $this->imageCollection->updateOne(
                ['_id' => $id],
                ['$set' => [
                    'sectionItemId' => $sectionItemId,
                    'title' => $title,
                    'description' => $description,
                    'caption' => $caption,
                    'date' => $date,
                    'url' => $url,
                    'editDate' => $editDate
                ]]
            )->getModifiedCount() > 0;
    }

    public function deleteImage($id): bool
    {
        return $this->imageCollection->deleteOne(['_id' => $id])->getDeletedCount() > 0;
    }
}