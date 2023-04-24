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
        } elseif (count($request->getExplodedPath()) > 4) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->sectionItemService->getAllSectionItems(),
            'creator' => $this->sectionItemService->getAllSectionItemsByCreatorId($request->getExplodedPath()[3]),
            'photo-album' => $this->sectionItemService->getAllSectionItemsByPhotoAlbumId($request->getExplodedPath()[3]),
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
            $request->getJsonInt('order'),
            $request->getJsonInt('rotation')
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
            $request->getJsonInt('order'),
            $request->getJsonInt('rotation')
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