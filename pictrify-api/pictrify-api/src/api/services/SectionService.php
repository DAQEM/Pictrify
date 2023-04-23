<?php

namespace Pictrify;

use Guid;
use UTCDate;

class SectionService extends BaseService
{
    private ISectionGateway $sectionGateway;
    private PhotoAlbumService $photoAlbumService;

    public function __construct(ISectionGateway $sectionGateway, IPhotoAlbumGateway $photoAlbumGateway, ICreatorGateway $creatorGateway)
    {
        $this->sectionGateway = $sectionGateway;
        $this->photoAlbumService = new PhotoAlbumService($photoAlbumGateway, $creatorGateway);
    }

    public function getAllSections(): array
    {
        return $this->sectionGateway->getAllSections();
    }

    public function getSectionsByCreatorId(mixed $int): array
    {
        return $this->sectionGateway->getSectionsByCreatorId($int);
    }

    public function getSectionsByPhotoAlbumId(mixed $int): array
    {
        return $this->sectionGateway->getSectionsByPhotoAlbumId($int);
    }

    /**
     * @throws NotFoundException if the section is not found.
     */
    public function getSectionById(mixed $int): array
    {
        $result = $this->sectionGateway->getSectionById($int);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws ForbiddenException
     */
    public function createSection($photoAlbumId, $title, $description, $sectionType): array
    {
        $id = Guid::newGuid();
        $creationDate = UTCDate::getUTCDateISO();

        if (!$this->photoAlbumService->photoAlbumIdExists($photoAlbumId)) {
            throw new ForbiddenException("The photo album does not exist.");
        }

        if (!$this->titleValid($title)) {
            throw new ForbiddenException("The title is not valid.");
        }

        if (!$this->descriptionValid($description)) {
            throw new ForbiddenException("The description is not valid.");
        }

        if (!$this->sectionTypeValid($sectionType)) {
            throw new ForbiddenException("The section type is not valid.");
        }

        $success =  $this->sectionGateway->createSection($id, $photoAlbumId, $title, $description, $sectionType, $creationDate);

        return $this->createdResponse($success, [
            'id' => $id,
            'photoAlbumId' => $photoAlbumId,
            'title' => $title,
            'description' => $description,
            'sectionType' => $sectionType,
            'creationDate' => $creationDate
        ]);
    }

    /**
     * @throws ForbiddenException if the values are invalid.
     */
    public function updateSection($id, $photoAlbumId, $title, $description, $sectionType): array
    {
        $editDate = UTCDate::getUTCDateISO();

        if (!$this->titleValid($title)) {
            throw new ForbiddenException("The title is not valid.");
        }

        if (!$this->descriptionValid($description)) {
            throw new ForbiddenException("The description is not valid.");
        }

        if (!$this->sectionTypeValid($sectionType)) {
            throw new ForbiddenException("The section type is not valid.");
        }

        $success = $this->sectionGateway->updateSection($id, $photoAlbumId, $title, $description, $sectionType, $editDate);

        return $this->updatedResponse($success, [
            'id' => $id,
            'photoAlbumId' => $photoAlbumId,
            'title' => $title,
            'description' => $description,
            'sectionType' => $sectionType,
            'editDate' => $editDate
        ]);
    }

    public function deleteSection(string $id): array
    {
        $success = $this->sectionGateway->deleteSection($id);

        return $this->deletedResponse($success, [
            'id' => $id
        ]);
    }

    private function titleValid($title): bool
    {
        /**
         * This regex matches a string of 2 to 64 characters that starts and
         * ends with an alphanumeric character, allows spaces, dashes, colons,
         * and forward slashes in between, but does not allow consecutive
         * spaces or more than one colon or forward slash in a row.
         */
        return preg_match('/^(?!\s)(?!.*\s{2})(?!.*:{2})(?!.*\/{2})[a-zA-Z0-9][a-zA-Z0-9\s\/\-:]{1,62}[a-zA-Z0-9](?<!\s)$/', $title);
    }

    private function descriptionValid($description): bool
    {
        /**
         * This regex matches a string of 1 to 4096 characters that contains
         * only alphanumeric characters, spaces, and the following special
         * characters: - , . ! ?
         */
        return preg_match('/^[a-zA-Z0-9\s\-_,.!?]{1,4096}$/', $description);
    }

    private function sectionTypeValid($sectionType): bool
    {
        /**
         * This regex matches a string that is either EMPTY, ONE_IMAGE, TWO_IMAGES,
         * THREE_IMAGES, FOUR_IMAGES, or FIVE_IMAGES.
         */
        return preg_match('/^(EMPTY|ONE_IMAGE|(TWO|THREE|FOUR|FIVE)_IMAGES)$/', $sectionType);
    }
}