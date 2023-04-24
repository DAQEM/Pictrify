<?php

namespace Pictrify\Repository;

use MongoDB\Collection;
use Pictrify\interfaces\ISectionItemRepository;

class SectionItemRepository implements ISectionItemRepository
{
    private Collection $sectionItemCollection;
    private SectionRepository $sectionRepository;

    public function __construct()
    {
        $this->sectionItemCollection = (new DatabaseHelper())->getSectionItemCollection();
        $this->sectionRepository = new SectionRepository();
    }

    public function getAllSectionItems(): array
    {
        return $this->sectionItemCollection->find()->toArray();
    }

    public function getSectionItemById(string $id): array
    {
        return (array)$this->sectionItemCollection->findOne(['_id' => $id]);
    }

    public function getAllSectionItemsBySectionId(string $sectionId): array
    {
        return $this->sectionItemCollection->find(['sectionId' => $sectionId])->toArray();
    }

    public function getAllSectionItemsByCreatorId(string $creatorId): array
    {
        $sectionItems = array();
        $sections = $this->sectionRepository->getAllSectionsByCreatorId($creatorId);

        foreach ($sections as $section) {
            $sectionItems = array_merge($sectionItems, $this->getAllSectionItemsBySectionId($section['_id']));
        }

        return $sectionItems;
    }

    public function getAllSectionItemsByPhotoAlbumId(string $creatorId): array
    {
        $sectionItems = array();
        $sections = $this->sectionRepository->getAllSectionsByPhotoAlbumId($creatorId);

        foreach ($sections as $section) {
            $sectionItems = array_merge($sectionItems, $this->getAllSectionItemsBySectionId($section['_id']));
        }

        return $sectionItems;
    }

    public function createSectionItem($id, $sectionId, $order, $rotation, $creationDate): bool
    {
        return $this->sectionItemCollection->insertOne([
                '_id' => $id,
                'sectionId' => $sectionId,
                'order' => $order,
                'rotation' => $rotation,
                'creationDate' => $creationDate
            ])->getInsertedCount() > 0;
    }

    public function updateSectionItem($id, $sectionId, $order, $rotation, $editDate): bool
    {
        return $this->sectionItemCollection->updateOne(
                ['_id' => $id],
                [
                    '$set' => [
                        'sectionId' => $sectionId,
                        'order' => $order,
                        'rotation' => $rotation,
                        'editDate' => $editDate,
                    ]
                ]
            )->getModifiedCount() > 0;
    }

    public function deleteSectionItem($id): bool
    {
        return $this->sectionItemCollection->deleteOne(['_id' => $id])->getDeletedCount() > 0;
    }
}