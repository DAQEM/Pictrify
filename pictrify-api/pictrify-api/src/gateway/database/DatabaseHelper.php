<?php

namespace Pictrify\Gateway;

use MongoDB\Collection;
use MongoDB\Database;

class DatabaseHelper
{
    private Database $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getConnection()->selectDatabase("pictrify");
    }

    private function getDatabase(): Database
    {
        return $this->db;
    }

    private function getCollection(string $collection): Collection
    {
        return $this->getDatabase()->selectCollection($collection);
    }

    public function getCreatorsCollection(): Collection
    {
        return $this->getCollection("creators");
    }

    public function getPhotoAlbumCollection(): Collection
    {
        return $this->getCollection("photo_album");
    }

    public function getSectionCollection(): Collection
    {
        return $this->getCollection("section");
    }
}