<?php

namespace Pictrify;

class SectionController extends BaseController
{
    private SectionService $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     * @throws NotFoundException if the section is not found.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->sectionService->getAllSections();
        } elseif (count($request->getExplodedPath()) > 4) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->sectionService->getAllSections(),
            'creator' => $this->sectionService->getSectionsByCreatorId($request->getExplodedPath()[3]),
            'photo-album' => $this->sectionService->getSectionsByPhotoAlbumId($request->getExplodedPath()[3]),
            default => $this->sectionService->getSectionById($request->getExplodedPath()[2]),
        };
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     * @throws ForbiddenException if the photo album does not exist or the values are invalid.
     * @throws BadRequestException if the json body is not valid.
     */
    public function handlePostRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 2) {
            throw new InvalidUrlException();
        }

        return $this->sectionService->createSection(
            $request->getJsonString('photo_album_id'),
            $request->getJsonString('title'),
            $request->getJsonString('description'),
            $request->getJsonString('section_type'),
        );
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     * @throws BadRequestException if the json body is not valid.
     * @throws ForbiddenException if the values are invalid.
     */
    public function handlePutRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 3) {
            throw new InvalidUrlException();
        }

        return $this->sectionService->updateSection(
            $request->getExplodedPath()[2],
            $request->getJsonString('photo_album_id'),
            $request->getJsonString('title'),
            $request->getJsonString('description'),
            $request->getJsonString('section_type'),
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

        return $this->sectionService->deleteSection($request->getExplodedPath()[2]);
    }
}