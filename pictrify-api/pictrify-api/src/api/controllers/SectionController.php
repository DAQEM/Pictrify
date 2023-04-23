<?php

namespace Pictrify;

use Pictrify\interfaces\IHttpGet;
use Pictrify\interfaces\IHttpPost;
use Pictrify\interfaces\IHttpPut;
use Pictrify\interfaces\IHttpDelete;

class SectionController extends BaseController implements IHttpGet, IHttpPost, IHttpPut, IHttpDelete
{

    /**
     * @throws NotFoundException if the section is not found.
     * @throws MethodNotAllowedException if the method is not allowed.
     * @throws BadRequestException if the json body is not valid.
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
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->getAllSections();
        }

        elseif (count($request->getExplodedPath()) > 3) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->getAllSections(),
            default => $this->getSectionById($request->getExplodedPath()[1]),
        };
    }

    public function handlePostRequest(Request $request): array
    {
        // TODO: Implement handlePostRequest() method.
    }

    public function handlePutRequest(Request $request): array
    {
        // TODO: Implement handlePutRequest() method.
    }

    public function handleDeleteRequest(Request $request): array
    {
        return match (count($request->getExplodedPath())) {
            2 => $this->deleteSection($request->getExplodedPath()[1]),
            default => throw new NotFoundException(),
        };
    }
}