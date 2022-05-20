<?php

namespace widgets\position;

use core\DB;

class Position
{
    private $pdo;

    public function __construct() {
        $this->pdo = DB::getPDO();
    }

    public function getPosition($name = ''):array {
        $query = "SELECT * FROM get_position(:name)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('name' => $name));

        return $stmt->fetchAll();
    }
}