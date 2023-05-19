<?php

namespace Pictrify\Repository;

use MongoDB\Collection;
use Pictrify\interfaces\ICreatorRepository;

class CreatorRepository implements ICreatorRepository
{
    private Collection $creatorCollection;

    public function __construct()
    {
        $this->creatorCollection = (new DatabaseHelper())->getCreatorCollection();
    }

    public function getAllCreators(): array
    {
        return $this->creatorCollection->find()->toArray();
    }

    public function getCreatorById($id): ?array
    {
        return (array)$this->creatorCollection->findOne(["_id" => $id]);
    }

    public function getCreatorByUsername($username): ?array
    {
        return (array)$this->creatorCollection->findOne(["username" => $username]);
    }

    public function getCreatorByEmail($email): ?array
    {
        return (array)$this->creatorCollection->findOne(["email" => $email]);
    }

    public function createCreator($id, $username, $email, $password_hash, $password_salt, $join_date): bool
    {
        return $this->creatorCollection->insertOne([
                "_id" => $id,
                "username" => $username,
                "email" => $email,
                "created_at" => $join_date,
                "password_hash" => $password_hash,
                "password_salt" => $password_salt
            ])->getInsertedCount() > 0;
    }

    public function updateCreator($id, $username, $email, $password_hash): bool
    {
        return $this->creatorCollection->updateOne(
                ["_id" => $id],
                [
                    '$set' => [
                        "username" => $username,
                        "email" => $email,
                        "password" => $password_hash
                    ]
                ]
            )->getModifiedCount() > 0;
    }

    public function deleteCreator($id): bool
    {
        return $this->creatorCollection->deleteOne(["_id" => $id])->getDeletedCount() > 0;
    }
}