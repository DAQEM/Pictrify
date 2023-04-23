<?php

namespace Pictrify;

use Pictrify\interfaces\IHttpDelete;
use Pictrify\interfaces\IHttpGet;
use Pictrify\interfaces\IHttpPost;
use Pictrify\interfaces\IHttpPut;

class CreatorController extends BaseController implements IHttpGet, IHttpPost, IHttpPut, IHttpDelete
{
    private CreatorService $creatorService;

    public function __construct(CreatorService $creatorService)
    {
        $this->creatorService = $creatorService;
    }

    /**
     * @throws NotFoundException if the creator is not found.
     * @throws MethodNotAllowedException if the method is not allowed.
     * @throws ForbiddenException if the username or email already exists.
     * @throws BadRequestException if the json body is not valid.
     * @throws InvalidUrlException if the url is invalid.
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
     * @throws NotFoundException if the creator is not found.
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->creatorService->getAllCreators();
        }
        elseif (count($request->getExplodedPath()) > 3) {
            throw new InvalidUrlException();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->creatorService->getAllCreators(),
            'username' => $this->creatorService->getCreatorByUsername($request->getExplodedPath()[3]),
            'email' => $this->creatorService->getCreatorByEmail($request->getExplodedPath()[3]),
            default => $this->creatorService->getCreatorById($request->getExplodedPath()[2]),
        };
    }

    /**
     * @throws ForbiddenException if the username or email already exists.
     * @throws BadRequestException if the json body is not valid.
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handlePostRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 2) {
            throw new InvalidUrlException();
        }

        return $this->creatorService->createCreator(
            $request->getJsonString('username'),
            $request->getJsonString('email')
        );
    }

    /**
     * @throws BadRequestException if the json body is not valid.
     * @throws InvalidUrlException if the url is invalid.
     * @throws ForbiddenException if the username or email already exists.
     */
    public function handlePutRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) !== 3) {
            throw new InvalidUrlException();
        }

        return $this->creatorService->updateCreator(
            $request->getExplodedPath()[2],
            $request->getJsonString('username'),
            $request->getJsonString('email')
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

        return $this->creatorService->deleteCreator($request->getExplodedPath()[2]);
    }
}