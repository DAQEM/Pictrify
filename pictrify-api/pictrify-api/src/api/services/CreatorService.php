<?php

namespace Pictrify;

use Guid;
use Pictrify\interfaces\ICreatorRepository;
use UTCDate;

class CreatorService extends BaseService
{
    public ICreatorRepository $creatorRepository;

    public function __construct(ICreatorRepository $creatorRepository)
    {
        $this->creatorRepository = $creatorRepository;
    }

    public function getAllCreators(): array
    {
        return $this->creatorRepository->getAllCreators();
    }

    /**
     * @throws NotFoundException if the creator is not found.
     */
    public function getCreatorById(string $id): ?array
    {
        $result = $this->creatorRepository->getCreatorById($id);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws NotFoundException if the creator is not found.
     */
    public function getCreatorByUsername(string $username): ?array
    {
        $result = $this->creatorRepository->getCreatorByUsername($username);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws NotFoundException if the creator is not found.
     */
    public function getCreatorByEmail(string $email): ?array
    {
        $result = $this->creatorRepository->getCreatorByEmail($email);

        return $result ?: throw new NotFoundException();
    }

    /**
     * @throws ForbiddenException if the username or email already exists or the values are not valid.
     */
    public function createCreator($username, $email): array
    {
        //create a new uuid v4 for the creator
        $id = Guid::newGuid();
        $isoDate = UTCDate::getUTCDateISO();

        if ($this->creatorUsernameExists($id, $username)) {
            throw new ForbiddenException('Username already exists');
        }

        if ($this->creatorEmailExists($id, $email)) {
            throw new ForbiddenException('Email already exists');
        }

        if (!$this->usernameValid($username)) {
            throw new ForbiddenException('Username is not valid');
        }

        if (!$this->emailValid($email)) {
            throw new ForbiddenException('Email is not valid');
        }

        $success = $this->creatorRepository->createCreator($id, $username, $email, $isoDate);

        return $this->createdResponse($success, [
            '_id' => $id,
            'username' => $username,
            'email' => $email,
            'join_date' => $isoDate,
        ]);
    }

    /**
     * @throws ForbiddenException if the username or email already exists or the values are not valid.
     */
    public function updateCreator($id, $username, $email): array
    {
        if ($this->creatorUsernameExists($id, $username)) {
            throw new ForbiddenException('Username already exists');
        }

        if ($this->creatorEmailExists($id, $email)) {
            throw new ForbiddenException('Email already exists');
        }

        if (!$this->usernameValid($username)) {
            throw new ForbiddenException('Username is not valid');
        }

        if (!$this->emailValid($email)) {
            throw new ForbiddenException('Email is not valid');
        }

        $success = $this->creatorRepository->updateCreator($id, $username, $email);

        return $this->updatedResponse($success, [
            '_id' => $id,
            'username' => $username,
            'email' => $email,
        ]);
    }

    public function deleteCreator(string $id): array
    {
        $success = $this->creatorRepository->deleteCreator($id);

        return $this->deletedResponse($success, [
            '_id' => $id,
        ], 'Creator with this id could not be found');
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

    private function creatorUsernameExists(string $id, string $username): bool
    {
        try {
            $result = $this->getCreatorByUsername($username);
            return $result['_id'] !== $id;
        } catch (NotFoundException) {
            return false;
        }
    }

    private function creatorEmailExists(string $id, string $email): bool
    {
        try {
            $result = $this->getCreatorByEmail($email);
            return $result['_id'] !== $id;
        } catch (NotFoundException) {
            return false;
        }
    }

    private function usernameValid(string $username): bool
    {
        return preg_match('/^[a-zA-Z0-9_]{2,30}$/', $username);
    }

    private function emailValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}