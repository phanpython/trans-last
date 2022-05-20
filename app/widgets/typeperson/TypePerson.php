<?php

namespace widgets\typeperson;

use core\DB;

class TypePerson
{
    protected $pdo;

    public function __construct() {
        $this->pdo = DB::getPDO();
    }

    public function getTypePerson($typePersonId) {
        $query = "SELECT * FROM get_type_person(:type_person_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('type_person_id' => $typePersonId));

        return $stmt->fetch();
    }
}