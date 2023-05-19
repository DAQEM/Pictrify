<?php

namespace Pictrify;

class CreatorController extends BaseController
{
    private CreatorService $creatorService;

    public function __construct(CreatorService $creatorService)
    {
        $this->creatorService = $creatorService;
    }

    /**
     * @throws NotFoundException if the creator is not found.
     * @throws InvalidUrlException if the url is invalid.
     */
    public function handleGetRequest(Request $request): array
    {
        if (count($request->getExplodedPath()) == 2) {
            return $this->creatorService->getAllCreators();
        } elseif (count($request->getExplodedPath()) > 4) {
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
            $request->getJsonString('email'),
            $request->getJsonString('password_hash'),
            $request->getJsonString('password_salt')
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
            $request->getJsonString('email'),
            $request->getJsonString('password_hash'),
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