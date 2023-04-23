<?php

namespace Pictrify;

use Guid;
use Pictrify\interfaces\IHttpDelete;
use Pictrify\interfaces\IHttpGet;
use Pictrify\interfaces\IHttpPost;
use Pictrify\interfaces\IHttpPut;
use UTCDate;

class PhotoAlbumController extends BaseController implements IHttpGet, IHttpPost, IHttpPut, IHttpDelete
{
    private IPhotoAlbumGateway $photoAlbumGateway;
    private CreatorController $creatorController;

    public function __construct(IPhotoAlbumGateway $photoAlbumGateway, ICreatorGateway $creatorGateway)
    {
        $this->photoAlbumGateway = $photoAlbumGateway;
        $this->creatorController = new CreatorController($creatorGateway);
    }

    /**
     * @throws MethodNotAllowedException if the request method is not allowed.
     * @throws BadRequestException if the json body is not valid.
     * @throws NotFoundException if the photo album is not found.
     * @throws ForbiddenException if the creator does not exist or if the creator already has a photo album with the same slug.
     * @throws InvalidUrlException if the url is invalid.
     */
    public function getResponse(Request $request): array
    {
        return match ($request->getMethod()) {
            'GET' => $this->handleGetRequest($request),
            'POST' => $this->handlePostRequest($request),
            'PUT' => $this->handlePutRequest($request),
            'DELETE' => $this->handleDeleteRequest($request),
            default => throw new MethodNotAllowedException()
        };
    }

    /**
     * @throws NotFoundException if the photo album is not found.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) < 3) {
            return $this->getAllPhotoAlbums();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->getAllPhotoAlbums(),
            'creator' => $this->getAllPhotoAlbumsByCreatorId($request->getExplodedPath()[3]),
            'slug' => $this->getPhotoAlbumBySlug($request->getExplodedPath()[3]),
            default => $this->getPhotoAlbumById($request->getExplodedPath()[2])
        };
    }


    /**
     * @throws ForbiddenException if the creator does not exist or if the creator already has a photo album with the same slug.
     * @throws InvalidUrlException if the url is invalid.
     * @throws BadRequestException if the json body is not valid.
     */
    public function handlePostRequest(Request $request): array
    {
        return match ($request->getExplodedPath()[2]) {
            '' => $this->createPhotoAlbum($request),
            default => throw new InvalidUrlException()
        };
    }

    /**
     * @throws BadRequestException if the json body is not valid.
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handlePutRequest(Request $request): array
    {
        return match ($request->getExplodedPath()[2]) {
            '' => $this->updatePhotoAlbum($request),
            default => throw new InvalidUrlException()
        };
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handleDeleteRequest(Request $request): array
    {
        return match ($request->getExplodedPath()[2]) {
            '' => $this->deletePhotoAlbum($request->getExplodedPath()[2]),
            default => throw new InvalidUrlException()
        };
    }

    private function getAllPhotoAlbums(): array
    {
        return $this->photoAlbumGateway->getAllPhotoAlbums();
    }

    private function getAllPhotoAlbumsByCreatorId(string $creatorId): array
    {
        return $this->photoAlbumGateway->getAllPhotoAlbumsByCreatorId($creatorId);
    }

    /**
     * @throws NotFoundException if the photo album is not found.
     */
    private function getPhotoAlbumBySlug(string $slug): array
    {
        $result = $this->photoAlbumGateway->getPhotoAlbumBySlug($slug);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws NotFoundException if the photo album is not found.
     */
    private function getPhotoAlbumByCreatorIdAndSlug(string $creatorId, string $slug): array
    {
        $result = $this->photoAlbumGateway->getPhotoAlbumByCreatorIdAndSlug($creatorId, $slug);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws NotFoundException if the photo album is not found.
     */
    private function getPhotoAlbumById(string $id): array
    {
        $result = $this->photoAlbumGateway->getPhotoAlbumById($id);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws BadRequestException if the json body is not valid.
     * @throws ForbiddenException if the creator already has a photo album with the same slug.
     */
    private function createPhotoAlbum(Request $request): array
    {
        $id = Guid::newGuid();
        $creatorId = $request->getJsonString('creator_id');
        $name = $request->getJsonString('name');
        $description = $request->getJsonString('description');
        $slug = $request->getJsonString('slug');
        $editDate = (new UTCDate())->getUTCDateISO();

        if (!$this->creatorController->creatorIdExists($creatorId)) {
            throw new ForbiddenException('The creator does not exist.');
        }

        if ($this->photoAlbumCreatorSlugExists($creatorId, $slug)) {
            throw new ForbiddenException('The creator already has a photo album with the same slug.');
        }

        if (!$this->nameValid($name)) {
            throw new BadRequestException('The name is not valid.');
        }

        if (!$this->descriptionValid($description)) {
            throw new BadRequestException('The description is not valid.');
        }

        if (!$this->slugValid($slug)) {
            throw new BadRequestException('The slug is not valid.');
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
     * @throws BadRequestException if the json body is not valid.
     */
    private function updatePhotoAlbum(Request $request): array
    {
        $id = $request->getExplodedPath()[2];
        $creatorId = $request->getJsonString('creator_id');
        $name = $request->getJsonString('name');
        $description = $request->getJsonString('description');
        $slug = $request->getJsonString('slug');
        $creationDate = (new UTCDate())->getUTCDateISO();

        if (!$this->nameValid($name)) {
            throw new BadRequestException('The name is not valid.');
        }

        if (!$this->descriptionValid($description)) {
            throw new BadRequestException('The description is not valid.');
        }

        if (!$this->slugValid($slug)) {
            throw new BadRequestException('The slug is not valid.');
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

    private function deletePhotoAlbum(string $id): array
    {
        $success = $this->photoAlbumGateway->deletePhotoAlbum($id);

        return $this->deletedResponse($success, ['id' => $id], 'Photo album with this id could not be found');
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