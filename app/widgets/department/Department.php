<?php

namespace widgets\department;

use core\DB;
use core\Twig;

class Department
{
    private $pdo;
    private $departments = [];

    public function __construct() {
    }

    public function setDepartments() {
        $pdo = $this->getPDO();
        $query = "SELECT * FROM get_departments";
        $stmt = $pdo->query($query);

        $this->departments = $stmt->fetchAll();
    }

    public function getDepartments():array {
        return $this->departments;
    }

    public function setVarsToTwig() {
        Twig::addVarsToArrayOfRender(['departments' => $this->getDepartments()]);
    }

    public function setPDO() {
        $this->pdo = DB::getPDO();
    }

    public function getPDO() {
        return $this->pdo;
    }
}