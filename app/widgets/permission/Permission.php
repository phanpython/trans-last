<?php

namespace widgets\permission;

use core\DB;

class   Permission
{
    protected $pdo;

    public function __construct() {
        $this->pdo = DB::getPDO();
    }

    public function getPermission($permissionId = 0, $number = '', $userId = 0, $search = '', $dateStart = '', $dateEnd = '', $statusId = 0):array {
        $query = "SELECT * FROM get_permission(:permission_id, :number, :user_id, :search, :date_start, :date_end, :status_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' => $permissionId, 'number' => $number, 'user_id' => $userId,
                            'search' => $search, 'date_start' => $dateStart, 'date_end' => $dateEnd, 'status_id' => $statusId));
        $results = $stmt->fetchAll();

        if($results) {
            foreach ($results as &$result) {
                $arrNumbers = explode('/', $result['number']);
                $result['first_number'] = $arrNumbers[0];

                if(isset($arrNumbers[1])) {
                    $result['second_number'] = $arrNumbers[1];
                } else {
                    $result['second_number'] = $arrNumbers[0];
                }
            }
        } else {
            return [];
        }

        return $results;
    }

    public function setPermission($description, $addition, $subdivisionId, $untypicalWork = '') {
        $query = "SELECT * FROM add_permission(0, '', :description, :addition, :subdivision_id, :untypical_work)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('description' => $description, 'addition' => $addition,
                             'subdivision_id' => $subdivisionId, 'untypical_work' => $untypicalWork));
        $_SESSION['idCurrentPermission'] =  $stmt->fetch()['id'];
    }

    public function updatePermission($permissionId, $description, $addition, $number, $subdivisionId, $untypicalWork) {
        $number = strval($number);
        $query = "SELECT * FROM update_permission(:permission_id, :number, :description, :addition, :subdivision_id, :untypical_work)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' => $permissionId, 'description' => $description, 'addition' => $addition,
            'number' => $number, 'subdivision_id' => $subdivisionId, 'untypical_work' => $untypicalWork));
    }

    public function connectUserAndPermission($userId, $permissionId) {
        $query = "SELECT * FROM connect_user_and_permission(:user_id, :permission_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('user_id' => $userId, 'permission_id' => $permissionId));
    }

    public function delPermission($permissionId) {
        $query = "SELECT * FROM del_permission(:permission_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' => $permissionId));
    }
}