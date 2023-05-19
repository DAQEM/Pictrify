<?php

namespace Pictrify\interfaces;

interface ICreatorRepository
{
    public function getAllCreators(): array;

    public function getCreatorById($id): ?array;

    public function getCreatorByUsername($username): ?array;

    public function getCreatorByEmail($email): ?array;

    public function createCreator($id, $username, $email, $password_hash, $password_salt, $image, $join_date): bool;

    public function updateCreator($id, $username, $email, $password_hash, $image): bool;

    public function deleteCreator($id): bool;
}