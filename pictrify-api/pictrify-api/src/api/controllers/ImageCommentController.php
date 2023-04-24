<?php

namespace Pictrify;

class ImageCommentController extends BaseController
{
    private ImageCommentService $imageCommentService;

    public function __construct(ImageCommentService $imageCommentService)
    {
        $this->imageCommentService = $imageCommentService;
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     * @throws NotFoundException if the image comment is not found.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->imageCommentService->getAllImageComments();
        } elseif (count($request->getExplodedPath()) > 4) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->imageCommentService->getAllImageComments(),
            'creator' => $this->imageCommentService->getImageCommentsByCreatorId($request->getExplodedPath()[3]),
            'image' => $this->imageCommentService->getImageCommentsByImageId($request->getExplodedPath()[3]),
            default => $this->imageCommentService->getImageCommentById($request->getExplodedPath()[2]),
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

        return $this->imageCommentService->createImageComment(
            $request->getJsonString('image_id'),
            $request->getJsonString('creator_id'),
            $request->getJsonString('text')
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

        return $this->imageCommentService->updateImageComment(
            $request->getExplodedPath()[2],
            $request->getJsonString('text')
        );
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     * @throws NotFoundException if the image comment is not found.
     */
    public function handleDeleteRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 3) {
            throw new InvalidUrlException();
        }

        return $this->imageCommentService->deleteImageComment($request->getExplodedPath()[2]);
    }
}