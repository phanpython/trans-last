<?php

namespace widgets\typicalwork;

use core\DB;

class TypicalWork
{
    protected $pdo;

    public function __construct() {
        $this->pdo = DB::getPDO();
    }

    public function getTypicalWork($permissionId = 0, $userId = 0) {
        $query = "SELECT * FROM get_typical_work(:permission_id, :user_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' => $permissionId, 'user_id' => $userId));

        return $stmt->fetchAll();
    }


    public function delTypicalWork($permissionId = 0, $typicalWorkId = 0) {
        $query = "SELECT * FROM del_typical_work(:permission_id, :typical_work_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' =>$permissionId, 'typical_work_id' => $typicalWorkId));
    }

    public function setTypicalWorks($permissionId = 0, $typicalWorkId = 0, $description = '') {
        $query = "SELECT * FROM add_typical_work(:permission_id, :typical_work_id, :description)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' => $permissionId, 'typical_work_id' => $typicalWorkId, 'description' => $description));
    }
}