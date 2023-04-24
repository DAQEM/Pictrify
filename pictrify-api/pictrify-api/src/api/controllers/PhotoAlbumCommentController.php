<?php

namespace Pictrify;

class PhotoAlbumCommentController extends BaseController
{
    private PhotoAlbumCommentService $photoAlbumCommentService;

    public function __construct(PhotoAlbumCommentService $photoAlbumCommentService)
    {
        $this->photoAlbumCommentService = $photoAlbumCommentService;
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     * @throws NotFoundException if the photo album comment is not found.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->photoAlbumCommentService->getAllPhotoAlbumComments();
        } elseif (count($request->getExplodedPath()) > 4) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->photoAlbumCommentService->getAllPhotoAlbumComments(),
            'creator' => $this->photoAlbumCommentService->getPhotoAlbumCommentsByCreatorId($request->getExplodedPath()[3]),
            'photo-album' => $this->photoAlbumCommentService->getPhotoAlbumCommentsByPhotoAlbumId($request->getExplodedPath()[3]),
            default => $this->photoAlbumCommentService->getPhotoAlbumCommentById($request->getExplodedPath()[2]),
        };
    }

    /**
     * @throws BadRequestException if the json body is not valid.
     * @throws InvalidUrlException if the url is invalid.
     * @throws ForbiddenException if the values are invalid.
     */
    public function handlePostRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 2) {
            throw new InvalidUrlException();
        }

        return $this->photoAlbumCommentService->createPhotoAlbumComment(
            $request->getJsonString('photo_album_id'),
            $request->getJsonString('creator_id'),
            $request->getJsonString('content')
        );
    }

    /**
     * @throws ForbiddenException if the values are invalid.
     * @throws BadRequestException if the json body is not valid.
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handlePutRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 3) {
            throw new InvalidUrlException();
        }

        return $this->photoAlbumCommentService->updatePhotoAlbumComment(
            $request->getExplodedPath()[2],
            $request->getJsonString('content')
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

        return $this->photoAlbumCommentService->deletePhotoAlbumComment($request->getExplodedPath()[2]);
    }
}