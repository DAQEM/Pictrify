<?php

namespace Pictrify;

use Guid;
use UTCDate;

class PhotoAlbumService extends BaseService
{
    private IPhotoAlbumGateway $photoAlbumGateway;
    private CreatorService $creatorService;

    public function __construct(IPhotoAlbumGateway $photoAlbumGateway, ICreatorGateway $creatorGateway)
    {
        $this->photoAlbumGateway = $photoAlbumGateway;
        $this->creatorService = new CreatorService($creatorGateway);
    }

    public function getAllPhotoAlbums(): array
    {
        return $this->photoAlbumGateway->getAllPhotoAlbums();
    }

    public function getAllPhotoAlbumsByCreatorId(string $creatorId): array
    {
        return $this->photoAlbumGateway->getAllPhotoAlbumsByCreatorId($creatorId);
    }

    /**
     * @throws NotFoundException if the photo album is not found.
     */
    public function getPhotoAlbumBySlug(string $slug): array
    {
        $result = $this->photoAlbumGateway->getPhotoAlbumBySlug($slug);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws NotFoundException if the photo album is not found.
     */
    public function getPhotoAlbumByCreatorIdAndSlug(string $creatorId, string $slug): array
    {
        $result = $this->photoAlbumGateway->getPhotoAlbumByCreatorIdAndSlug($creatorId, $slug);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws NotFoundException if the photo album is not found.
     */
    public function getPhotoAlbumById(string $id): array
    {
        $result = $this->photoAlbumGateway->getPhotoAlbumById($id);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws ForbiddenException if the creator does not exist or if the creator already has a photo album with the same slug.
     */
    public function createPhotoAlbum($creatorId, $name, $description, $slug): array
    {
        $id = Guid::newGuid();
        $editDate = UTCDate::getUTCDateISO();

        if (!$this->creatorService->creatorIdExists($creatorId)) {
            throw new ForbiddenException('The creator does not exist.');
        }

        if ($this->photoAlbumCreatorSlugExists($creatorId, $slug)) {
            throw new ForbiddenException('The creator already has a photo album with the same slug.');
        }

        if (!$this->nameValid($name)) {
            throw new ForbiddenException('The name is not valid.');
        }

        if (!$this->descriptionValid($description)) {
            throw new ForbiddenException('The description is not valid.');
        }

        if (!$this->slugValid($slug)) {
            throw new ForbiddenException('The slug is not valid.');
        }

        $success = $this->photoAlbumGateway->createPhotoAlbum($id, $creatorId, $name, $description, $slug, $editDate);

        return $this->createdResponse($success, [
            'id' => $id,
            'creator_id' => $creatorId,
            'name' => $name,
            'description' => $description,
            'slug' => $slug,
            'edit_date' => $editDate
        ]);
    }

    /**
     * @throws ForbiddenException if the values are invalid.
     */
    public function updatePhotoAlbum($id, $creatorId, $name, $description, $slug): array
    {
        $creationDate = UTCDate::getUTCDateISO();

        if (!$this->nameValid($name)) {
            throw new ForbiddenException('The name is not valid.');
        }

        if (!$this->descriptionValid($description)) {
            throw new ForbiddenException('The description is not valid.');
        }

        if (!$this->slugValid($slug)) {
            throw new ForbiddenException('The slug is not valid.');
        }

        $success = $this->photoAlbumGateway->updatePhotoAlbum($id, $creatorId, $name, $description, $slug, $creationDate);

        return $this->updatedResponse($success, [
            'id' => $id,
            'creator_id' => $creatorId,
            'name' => $name,
            'description' => $description,
            'slug' => $slug,
            'creation_date' => $creationDate
        ]);
    }

    public function deletePhotoAlbum(string $id): array
    {
        $success = $this->photoAlbumGateway->deletePhotoAlbum($id);

        return $this->deletedResponse($success, ['id' => $id], 'Photo album with this id could not be found');
    }

    public function photoAlbumIdExists($photoAlbumId): bool
    {
        try {
            $this->getPhotoAlbumById($photoAlbumId);
            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    private function photoAlbumCreatorSlugExists(string $creatorId, string $slug): bool
    {
        try {
            $this->getPhotoAlbumByCreatorIdAndSlug($creatorId, $slug);
            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    private function nameValid(string $name): bool
    {
        /**
         * This regex matches a string of 2 to 64 characters that starts and
         * ends with an alphanumeric character, allows spaces, dashes, colons,
         * and forward slashes in between, but does not allow consecutive
         * spaces or more than one colon or forward slash in a row.
         */
        return preg_match('/^(?!\s)(?!.*\s{2})(?!.*:{2})(?!.*\/{2})[a-zA-Z0-9][a-zA-Z0-9\s\/\-:]{1,62}[a-zA-Z0-9](?<!\s)$/', $name);
    }

    private function descriptionValid(string $description): bool
    {
        /**
         * This regex matches a string of 1 to 4096 characters that contains
         * only alphanumeric characters, spaces, and the following special
         * characters: - , . ! ?
         */
        return preg_match('/^[a-zA-Z0-9\s\-_,.!?]{1,4096}$/', $description);
    }

    private function slugValid(string $slug): bool
    {
        /**
         * This regular expression matches strings consisting of one or more
         * alphanumeric characters, optionally separated by hyphens, with a
         * length between 3 and 64 characters and no consecutive hyphens.
         */
        return preg_match('/^(?=.{3,64}$)[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug);
    }
}