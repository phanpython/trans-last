<?php

namespace widgets\subdivision;

use core\DB;

class Subdivision
{
    private $pdo;

    public function __construct() {
        $this->pdo = DB::getPDO();
    }

    public function getSubdivision($subdivisionId = 0, $parentId = 0, $userId = 0) {
        $query = "SELECT * FROM get_subdivision(:subdivision_id, :parent_id, :user_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('subdivision_id' => $subdivisionId, 'parent_id' => $parentId, 'user_id' => $userId));

        return $stmt->fetchAll();
    }
}