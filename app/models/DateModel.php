<?php

namespace models;

use widgets\date\Date;

class DateModel extends AppModel
{
    protected $date;

    public function __construct() {
        $this->date = new Date();
    }

    public function setDates() {
        $this->date->delDates($_SESSION['idCurrentPermission']);
        $counter = 0;

        while (isset($_POST['date-' . $counter + 1])) {
            $counter++;
            $this->date->setDate($_POST['date-' . $counter], $_POST['from-time-' . $counter], $_POST['to-time-' . $counter], $_SESSION['idCurrentPermission']);
        }

        $this->redirect('permission', 'add');
    }

    public function getIndexVarsToTwig():array {
        return ['dates' => $this->date->getDates($_SESSION['idCurrentPermission'])];
    }
}