<?php

namespace Pictrify\interfaces;

interface ICreatorGateway
{
    public function getAllCreators(): array;

    public function getCreatorById($id): ?array;

    public function getCreatorByUsername($username): ?array;

    public function getCreatorByEmail($email): ?array;

    public function createCreator($id, $username, $email, $join_date): bool;

    public function updateCreator($id, $username, $email): bool;

    public function deleteCreator($id): bool;
}