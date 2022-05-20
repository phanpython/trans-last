<?php

namespace widgets\status;

use core\DB;

class Status
{
    protected $pdo;

    public function __construct() {
        $this->pdo = DB::getPDO();
    }

    public function getStatuses() {
        $query = "SELECT * FROM get_status()";
        $stmt = $this->pdo->query($query);

        return $stmt->fetchAll();
    }
}