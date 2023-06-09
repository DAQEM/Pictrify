<?php

namespace Pictrify;

use Guid;
use Pictrify\interfaces\ISectionItemRepository;
use UTCDate;

class SectionItemService extends BaseService
{
    private ISectionItemRepository $sectionItemRepository;
    private SectionService $sectionService;

    public function __construct(ISectionItemRepository $sectionItemRepository, SectionService $sectionService)
    {
        $this->sectionItemRepository = $sectionItemRepository;
        $this->sectionService = $sectionService;
    }

    public function getAllSectionItems(): array
    {
        return $this->sectionItemRepository->getAllSectionItems();
    }

    /**
     * @throws NotFoundException if the section item is not found.
     */
    public function getSectionItemById(string $id): array
    {
        $result = $this->sectionItemRepository->getSectionItemById($id);

        return $result ?: throw new NotFoundException();
    }

    public function getAllSectionItemsBySectionId(string $sectionId): array
    {
        return $this->sectionItemRepository->getAllSectionItemsBySectionId($sectionId);
    }

    public function getAllSectionItemsByCreatorId(string $creatorId): array
    {
        return $this->sectionItemRepository->getAllSectionItemsByCreatorId($creatorId);
    }

    public function getAllSectionItemsByPhotoAlbumId(string $creatorId): array
    {
        return $this->sectionItemRepository->getAllSectionItemsByPhotoAlbumId($creatorId);
    }

    /**
     * @throws ForbiddenException if the section does not exist, the order is not valid or the rotation is not valid.
     */
    public function createSectionItem($sectionId, $order, $rotation): array
    {
        $id = Guid::newGuid();
        $creationDate = UTCDate::nowISO();

        if (!$this->sectionService->sectionIdExists($sectionId)) {
            throw new ForbiddenException("The section does not exist.");
        }

        if (!$this->orderValid($order)) {
            throw new ForbiddenException("The order is not valid.");
        }

        if (!$this->rotationValid($rotation)) {
            throw new ForbiddenException("The rotation is not valid.");
        }

        $success = $this->sectionItemRepository->createSectionItem($id, $sectionId, $order, $rotation, $creationDate);

        return $this->createdResponse($success, [
            "id" => $id,
            "sectionId" => $sectionId,
            "order" => $order,
            "rotation" => $rotation,
            "creationDate" => $creationDate
        ]);
    }

    /**
     * @throws ForbiddenException if the order is not valid or the rotation is not valid.
     */
    public function updateSectionItem($id, $sectionId, $order, $rotation): array
    {
        $editDate = UTCDate::nowISO();

        if (!$this->orderValid($order)) {
            throw new ForbiddenException("The order is not valid.");
        }

        if (!$this->rotationValid($rotation)) {
            throw new ForbiddenException("The rotation is not valid.");
        }

        $success = $this->sectionItemRepository->updateSectionItem($id, $sectionId, $order, $rotation, $editDate);

        return $this->createdResponse($success, [
            "id" => $id,
            "sectionId" => $sectionId,
            "order" => $order,
            "rotation" => $rotation,
            "editDate" => $editDate
        ]);
    }

    public function deleteSectionItem($id): array
    {
        $success = $this->sectionItemRepository->deleteSectionItem($id);

        return $this->createdResponse($success, [
            "id" => $id
        ], 'Section item with this id could not be found');
    }

    public function sectionItemIdExists($sectionItemId): bool
    {
        try {
            $this->getSectionItemById($sectionItemId);
            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    private function orderValid($order): bool
    {
        return is_int($order) && $order >= 1;
    }

    public function rotationValid($rotation): bool
    {
        return is_int($rotation) && $rotation >= 0 && $rotation <= 360;
    }
}