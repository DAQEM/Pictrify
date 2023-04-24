<?php

namespace Pictrify;

class SectionItemController extends BaseController
{
    private SectionItemService $sectionItemService;

    public function __construct(SectionItemService $sectionItemService)
    {
        $this->sectionItemService = $sectionItemService;
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->sectionItemService->getAllSectionItems();
        } elseif (count($request->getExplodedPath()) > 3) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->sectionItemService->getAllSectionItems(),
            'section' => $this->sectionItemService->getAllSectionItemsBySectionId($request->getExplodedPath()[3]),
            default => $this->sectionItemService->getSectionItemById($request->getExplodedPath()[2]),
        };
    }

    /**
     * @throws InvalidUrlException if the url is invalid.
     * @throws BadRequestException if the json body is not valid.
     * @throws ForbiddenException if the values are invalid.
     */
    public function handlePostRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 2) {
            throw new InvalidUrlException();
        }

        return $this->sectionItemService->createSectionItem(
            $request->getJsonString('section_id'),
            $request->getJsonString('photo_album_id'),
            $request->getJsonString('order')
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

        return $this->sectionItemService->updateSectionItem(
            $request->getExplodedPath()[2],
            $request->getJsonString('section_id'),
            $request->getJsonString('photo_album_id'),
            $request->getJsonString('order')
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

        return $this->sectionItemService->deleteSectionItem($request->getExplodedPath()[2]);
    }
}