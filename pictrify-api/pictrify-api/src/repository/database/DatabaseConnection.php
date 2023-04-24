<?php

namespace Pictrify\Repository;

use MongoDB\Client;

class DatabaseConnection
{
    private static ?Client $connection = null;

    public static function getConnection(): ?Client
    {
        if (self::$connection == null) {
            self::$connection = new Client("mongodb://root:mongopwd@mongo:27017");
        }
        return self::$connection;
    }
}