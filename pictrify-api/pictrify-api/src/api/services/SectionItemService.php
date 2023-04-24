<?php

namespace Pictrify;

use Guid;
use Pictrify\interfaces\ISectionItemGateway;
use UTCDate;

class SectionItemService extends BaseService
{
    private ISectionItemGateway $sectionItemGateway;
    private SectionService $sectionService;

    public function __construct(ISectionItemGateway $sectionItemGateway, SectionService $sectionService)
    {
        $this->sectionItemGateway = $sectionItemGateway;
        $this->sectionService = $sectionService;
    }

    public function getAllSectionItems(): array
    {
        return $this->sectionItemGateway->getAllSectionItems();
    }

    public function getSectionItemById(string $id): array
    {
        return $this->sectionItemGateway->getSectionItemById($id);
    }

    public function getAllSectionItemsBySectionId(string $sectionId): array
    {
        return $this->sectionItemGateway->getAllSectionItemsBySectionId($sectionId);
    }

    /**
     * @throws ForbiddenException if the section does not exist, the order is not valid or the rotation is not valid.
     */
    public function createSectionItem($sectionId, $order, $rotation): array
    {
        $id = Guid::newGuid();
        $creationDate = UTCDate::getUTCDateISO();

        if (!$this->sectionService->sectionIdExists($sectionId)) {
            throw new ForbiddenException("The section does not exist.");
        }

        if (!$this->orderValid($order)) {
            throw new ForbiddenException("The order is not valid.");
        }

        if (!$this->rotationValid($rotation)) {
            throw new ForbiddenException("The rotation is not valid.");
        }

        $success = $this->sectionItemGateway->createSectionItem($id, $sectionId, $order, $rotation, $creationDate);

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
        $editDate = UTCDate::getUTCDateISO();

        if (!$this->orderValid($order)) {
            throw new ForbiddenException("The order is not valid.");
        }

        if (!$this->rotationValid($rotation)) {
            throw new ForbiddenException("The rotation is not valid.");
        }

        $success = $this->sectionItemGateway->updateSectionItem($id, $sectionId, $order, $rotation, $editDate);

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
        $success = $this->sectionItemGateway->deleteSectionItem($id);

        return $this->createdResponse($success, [
            "id" => $id
        ], 'Section item with this id could not be found');
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