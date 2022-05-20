<?php

namespace widgets\statuslog;

use core\DB;

class StatusLog
{
    protected $pdo;

    public function __construct() {
        $this->pdo = DB::getPDO();
    }

    public function addStatusManagementLog($permissionId = 0, $statusId = 0, $userId = 0, $comment = '', $dateChangeStatus = '') {
        if($dateChangeStatus === '') {
            $dateChangeStatus = date('d.m.Y h:i:s');
        }

        $query = "SELECT * FROM add_status_management_log(:permission_id, :status_id, :user_id, :comment, :date_change_status)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' => $permissionId, 'status_id' => $statusId, 'user_id' => $userId,
                             'comment' => $comment, 'date_change_status' => $dateChangeStatus));
    }
}