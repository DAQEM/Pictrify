<?php

namespace Pictrify;

class ImageController extends BaseController
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->imageService->getAllImages();
        } elseif (count($request->getExplodedPath()) > 4) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->imageService->getAllImages(),
            'creator' => $this->imageService->getAllImagesByCreatorId($request->getExplodedPath()[3]),
            'photo-album' => $this->imageService->getAllImagesByPhotoAlbumId($request->getExplodedPath()[3]),
            'section' => $this->imageService->getAllImagesBySectionId($request->getExplodedPath()[3]),
            'section-item' => $this->imageService->getImageBySectionItemId($request->getExplodedPath()[3]),
            default => $this->imageService->getImageById($request->getExplodedPath()[2]),
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

        return $this->imageService->createImage(
            $request->getJsonString('section_item_id'),
            $request->getJsonString('title'),
            $request->getJsonString('description'),
            $request->getJsonString('caption'),
            $request->getJsonString('date'),
            $request->getJsonString('url')
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

        return $this->imageService->updateImage(
            $request->getExplodedPath()[2],
            $request->getJsonString('section_item_id'),
            $request->getJsonString('title'),
            $request->getJsonString('description'),
            $request->getJsonString('caption'),
            $request->getJsonString('date'),
            $request->getJsonString('url')
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

        return $this->imageService->deleteImage($request->getExplodedPath()[2]);
    }
}