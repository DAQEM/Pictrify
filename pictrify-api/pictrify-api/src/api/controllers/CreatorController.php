<?php

namespace Pictrify;

use Guid;
use UTCDate;

class CreatorController extends BaseController
{
    private ICreatorGateway $creatorsGateway;

    public function __construct(ICreatorGateway $creatorsGateway)
    {
        $this->creatorsGateway = $creatorsGateway;
    }

    /**
     * @throws NotFoundException if the creator is not found.
     * @throws MethodNotAllowedException if the method is not allowed.
     * @throws ForbiddenException if the username or email already exists.
     * @throws BadRequestException if the json body is not valid.
     */
    public function getCreatorsResponse(Request $request): array
    {
        return match ($request->getMethod()) {
            'GET' => $this->getCreators($request),
            'POST' => $this->createCreator($request),
            'PUT' => $this->updateCreator($request),
            'DELETE' => $this->deleteCreator($request),
            default => throw new MethodNotAllowedException(),
        };
    }

    /**
     * @throws NotFoundException if the creator is not found.
     */
    private function getCreators(Request $request): array
    {
        if (count($request->getExplodedPath()) < 3) {
            return $this->getAllCreators();
        }

        return match ($request->getExplodedPath()[2]) {
            '' => $this->getAllCreators(),
            'username' => $this->getCreatorByUsername($request->getExplodedPath()[3]),
            'email' => $this->getCreatorByEmail($request->getExplodedPath()[3]),
            default => $this->getCreatorById($request->getExplodedPath()[2]),
        };
    }

    /**
     * @throws ForbiddenException if the username or email already exists.
     * @throws BadRequestException if the json body is not valid.
     */
    private function createCreator(Request $request): array
    {
        //create a new uuid v4 for the creator
        $id = Guid::newGuid();
        $username = $request->getJsonString('username');
        $email = $request->getJsonString('email');
        $isoDate = (new UTCDate())->getUTCDateISO();

        if ($this->creatorUsernameExists($username)) {
            throw new ForbiddenException('Username already exists');
        }

        if ($this->creatorEmailExists($email)) {
            throw new ForbiddenException('Email already exists');
        }

        if (!$this->usernameValid($username)) {
            throw new BadRequestException('Username is not valid');
        }

        if (!$this->emailValid($email)) {
            throw new BadRequestException('Email is not valid');
        }

        $success = $this->creatorsGateway->createCreator($id, $username, $email, $isoDate);

        return $this->createdResponse($success, [
            '_id' => $id,
            'username' => $username,
            'email' => $email,
            'join_date' => $isoDate,
        ]);
    }

    /**
     * @throws BadRequestException if the json body is not valid.
     */
    private function updateCreator(Request $request): array
    {
        $id = $request->getExplodedPath()[2];
        $username = $request->getJsonString('username');
        $email = $request->getJsonString('email');

        if (!$this->usernameValid($username)) {
            throw new BadRequestException('Username is not valid');
        }

        if (!$this->emailValid($email)) {
            throw new BadRequestException('Email is not valid');
        }

        $success = $this->creatorsGateway->updateCreator($id, $username, $email);

        return $this->updatedResponse($success, [
            '_id' => $id,
            'username' => $username,
            'email' => $email,
        ]);
    }

    private function deleteCreator(Request $request): array
    {
        $id = $request->getExplodedPath()[2];

        $success = $this->creatorsGateway->deleteCreator($id);

        return $this->deletedResponse($success, [
            '_id' => $id,
        ],
            "Creator with this id could not be found");
    }

    private function getAllCreators(): array
    {
        return $this->creatorsGateway->getAllCreators();
    }

    /**
     * @throws NotFoundException if the creator is not found.
     */
    private function getCreatorById(string $id): ?array
    {
        $result = $this->creatorsGateway->getCreatorById($id);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws NotFoundException if the creator is not found.
     */
    private function getCreatorByUsername(string $username): ?array
    {
        $result = $this->creatorsGateway->getCreatorByUsername($username);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws NotFoundException if the creator is not found.
     */
    private function getCreatorByEmail(string $email): ?array
    {
        $result = $this->creatorsGateway->getCreatorByEmail($email);

        return $result ?: throw new NotFoundException();
    }

    public function creatorIdExists(string $id): bool
    {
        try {
            $this->getCreatorById($id);
            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    private function creatorUsernameExists(string $username): bool
    {
        try {
            $this->getCreatorByUsername($username);
            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    private function creatorEmailExists(string $email): bool
    {
        try {
            $this->getCreatorByEmail($email);
            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    private function usernameValid(string $username): bool
    {
        return preg_match('/^[a-zA-Z0-9_]{3,16}$/', $username);
    }

    private function emailValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}