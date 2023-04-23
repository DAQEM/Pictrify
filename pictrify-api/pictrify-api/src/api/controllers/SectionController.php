<?php

namespace Pictrify;

use Pictrify\interfaces\IHttpGet;
use Pictrify\interfaces\IHttpPost;
use Pictrify\interfaces\IHttpPut;
use Pictrify\interfaces\IHttpDelete;

class SectionController extends BaseController implements IHttpGet, IHttpPost, IHttpPut, IHttpDelete
{
    private SectionService $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    /**
     * @throws NotFoundException if the section is not found.
     * @throws MethodNotAllowedException if the method is not allowed.
     * @throws BadRequestException if the json body is not valid.
     * @throws InvalidUrlException if the url is invalid.
     * @throws ForbiddenException if the photo album does not exist or the values are invalid.
     */
    public function getResponse(Request $request): array
    {
        return match ($request->getMethod()) {
            'GET' => $this->handleGetRequest($request),
            'POST' => $this->handlePostRequest($request),
            'PUT' => $this->handlePutRequest($request),
            'DELETE' => $this->handleDeleteRequest($request),
            default => throw new MethodNotAllowedException(),
        };
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     * @throws NotFoundException if the section is not found.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->sectionService->getAllSections();
        }

        elseif (count($request->getExplodedPath()) > 3) {
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
        return match ($request->getExplodedPath()[2]) {
            '' => $this->sectionService->createSection(
                $request->getJsonString('photo_album_id'),
                $request->getJsonString('title'),
                $request->getJsonString('description'),
                $request->getJsonString('section_type'),
            ),
            default => throw new InvalidUrlException(),
        };
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
        return match ($request->getExplodedPath()[2]) {
            '' => $this->sectionService->deleteSection($request->getExplodedPath()[2]),
            default => throw new InvalidUrlException(),
        };
    }
}