<?php

namespace core;
use PDO;

class DB
{
    private static $pdo;

    public static function createPDO() {
        extract(require_once CONF . "/db.php");

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        self::$pdo = new PDO($dsn, $username, $password);
    }

    public static function getPDO() {
        return self::$pdo;
    }
}