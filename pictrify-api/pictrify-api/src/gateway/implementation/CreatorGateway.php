<?php

namespace Pictrify\Gateway;

use MongoDB\Collection;
use Pictrify\ICreatorGateway;

class CreatorGateway implements ICreatorGateway
{
    private Collection $creatorCollection;

    public function __construct()
    {
        $this->creatorCollection = (new DatabaseHelper())->getCreatorsCollection();
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

    public function createCreator($id, $username, $email, $join_date): bool
    {
        return $this->creatorCollection->insertOne([
                "_id" => $id,
                "username" => $username,
                "email" => $email,
                "created_at" => $join_date
            ])->getInsertedCount() > 0;
    }

    public function updateCreator($id, $username, $email): bool
    {
        return $this->creatorCollection->updateOne(
                ["_id" => $id],
                [
                    '$set' => [
                        "username" => $username,
                        "email" => $email
                    ]
                ]
            )->getModifiedCount() > 0;
    }

    public function deleteCreator($id): bool
    {
        return $this->creatorCollection->deleteOne(["_id" => $id])->getDeletedCount() > 0;
    }
}