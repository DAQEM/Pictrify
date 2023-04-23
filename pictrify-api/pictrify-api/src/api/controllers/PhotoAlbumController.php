<?php

namespace Pictrify;

use Pictrify\interfaces\IHttpDelete;
use Pictrify\interfaces\IHttpGet;
use Pictrify\interfaces\IHttpPost;
use Pictrify\interfaces\IHttpPut;

class PhotoAlbumController extends BaseController implements IHttpGet, IHttpPost, IHttpPut, IHttpDelete
{
    private PhotoAlbumService $photoAlbumService;

    public function __construct(PhotoAlbumService $photoAlbumService)
    {
        $this->photoAlbumService = $photoAlbumService;
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
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->photoAlbumService->getAllPhotoAlbums();
        }

        elseif (count($request->getExplodedPath()) > 3) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->photoAlbumService->getAllPhotoAlbums(),
            'creator' => $this->photoAlbumService->getAllPhotoAlbumsByCreatorId($request->getExplodedPath()[3]),
            'slug' => $this->photoAlbumService->getPhotoAlbumBySlug($request->getExplodedPath()[3]),
            default => $this->photoAlbumService->getPhotoAlbumById($request->getExplodedPath()[2])
        };
    }


    /**
     * @throws ForbiddenException if the creator does not exist or if the creator already has a photo album with the same slug.
     * @throws InvalidUrlException if the url is invalid.
     * @throws BadRequestException if the json body is not valid.
     */
    public function handlePostRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 2) {
            throw new InvalidUrlException();
        }

        return $this->photoAlbumService->createPhotoAlbum(
            $request->getJsonString('creator_id'),
            $request->getJsonString('name'),
            $request->getJsonString('description'),
            $request->getJsonString('slug')
        );
    }

    /**
     * @throws BadRequestException if the json body is not valid.
     * @throws InvalidUrlException if the url is invalid.
     * @throws ForbiddenException if the values are invalid.
     */
    public function handlePutRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 3) {
            throw new InvalidUrlException();
        }

        return $this->photoAlbumService->updatePhotoAlbum(
            $request->getExplodedPath()[2],
            $request->getJsonString('creator_id'),
            $request->getJsonString('name'),
            $request->getJsonString('description'),
            $request->getJsonString('slug')
        );
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handleDeleteRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 3) {
            throw new InvalidUrlException();
        }

        return $this->photoAlbumService->deletePhotoAlbum($request->getExplodedPath()[2]);
    }
}