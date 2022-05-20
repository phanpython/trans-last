<?php

namespace models;

use widgets\date\Date;
use widgets\permission\Permission;
use widgets\employee\Employee;
use widgets\protection\Protection;
use widgets\role\Role;
use widgets\status\Status;
use widgets\statuslog\StatusLog;
use widgets\typicalwork\TypicalWork;
use widgets\user\User;

class PermissionModel extends AppModel
{
    protected $typicalWork;
    protected $permission;
    protected $date;
    protected $user;
    protected $role;
    protected $employee;
    protected $statusLog;
    protected $status;

    public function __construct() {
        $this->employee = new Employee();
        $this->permission = new Permission();
        $this->typicalWork = new TypicalWork();
        $this->date = new Date();
        $this->user = new User();
        $this->role = new Role();
        $this->statusLog = new StatusLog();
        $this->status = new Status();
        $this->protection = new Protection();
    }

    public function addStatusOfPermission($idStatus, $comment, $date, $time) {
        $comment = htmlspecialchars(trim($comment));
        $date = $date . ' ' .$time;

        $this->statusLog->addStatusManagementLog($_SESSION['idCurrentPermission'], $idStatus, $_COOKIE['user'], $comment, $date);

        $this->redirect('permission', '');
    }

    public function updatePermission($description, $addition) {
        $permission = $this->permission->getPermission($_SESSION['idCurrentPermission'])[0];
        $this->permission->updatePermission($permission['id'], $permission['date_create'], $description, $addition,
                                            $permission['number'], $permission['subdivision_id'], $permission['untypical_work']);

        $this->redirect('permission', 'add');
    }

    public function updateNumber($firstNumber, $secondNumber) {
        $number = $firstNumber . '/' . $secondNumber;
        $permission = $this->permission->getPermission($_SESSION['idCurrentPermission'])[0];
        $this->permission->updatePermission($permission['id'], $permission['description'], $permission['addition'],
            $number, $permission['subdivision_id'], $permission['untypical_work']);

        $this->redirect('permission', 'add');
    }

    public function createPermission() {
        $subdivision = $this->user->getUsers($_COOKIE['user'], '', 2, 0)[0]['subdivision_id'];
        $this->permission->setPermission('', '', $subdivision);
        $this->permission->connectUserAndPermission($_COOKIE['user'], $_SESSION['idCurrentPermission']);
        $this->statusLog->addStatusManagementLog($_SESSION['idCurrentPermission'], 1, $_COOKIE['user'], '');
        $supervisor = $this->user->getUsers(0, '', 2, $subdivision, '', 1);

        if(isset($supervisor[0])) {
            $supervisorId = $supervisor[0]['user_id'];
            $this->employee->addEmployee($supervisorId, $_SESSION['idCurrentPermission'], 5);
        }

        $this->redirect('permission', 'add');
    }

    public function delPermission($permissionId) {
        $this->permission->delPermission($permissionId);
        $this->redirect('permission', '');
    }

    public function editPermission($permissionId) {
        $_SESSION['idCurrentPermission'] = $permissionId;
        $this->redirect('permission', 'add');
    }

    public function createPermissionById($permissionId) {
        $permission = $this->permission->getPermission($permissionId)[0];
        $this->permission->setPermission($permission['description'], $permission['addition'], $permission['subdivision_id'], $permission['untypical_work']);
        $dates = $this->date->getDates($permissionId);
        $employees = $this->employee->getEmployee(0, $permissionId);
        $typicalWorks = $this->typicalWork->getTypicalWork($permissionId, $_COOKIE['user']);

        foreach ($typicalWorks as $typicalWork) {
            $this->typicalWork->setTypicalWorks($_SESSION['idCurrentPermission'], $typicalWork['typical_work_id'], $typicalWork['description']);
        }

        foreach ($dates as $date) {
            $this->date->setDate($date['date'], $date['from_time'], $date['to_time'], $_SESSION['idCurrentPermission']);
        }

        foreach ($employees as $employee) {
            $this->employee->addEmployee($employee['user_id'], $_SESSION['idCurrentPermission'], $employee['type_person_id']);
        }

        $this->redirect('permission', 'add');
    }

    public function getDispatcherStatuses():array {
        $statuses = $this->status->getStatuses();
        $result = [];

        foreach ($statuses as $status) {
            if(($status['id'] === 3 || $status['parent_id'] === 3) && $status['id'] !== 6) {
                $result[] =  $status;
            }
        }

        return $result;
    }

    protected function getAuthorStatuses():array {
       $result = [];
       $statuses = $this->status->getStatuses();

        foreach ($statuses as $status) {
            if($status['id'] !== 6) {
                $result[] =  $status;
            }
        }

       return $result;
    }

    protected function setSessionsForFilter() {
        if(isset($_POST['date_start'])) {
            $_SESSION['date_start'] = $_POST['date_start'];
            $_SESSION['date_end'] = $_POST['date_end'];
        }

        if(isset($_POST['statuses'])) {
            $_SESSION['statuses'] = $_POST['statuses'];
        }

        $_SESSION['filter'] = $_POST['filter'];
    }

    protected function filterPermissionByDates():array {
        $permissions =  $this->permission->getPermission(0, '', $_COOKIE['user'], '', $_SESSION['date_start'], $_SESSION['date_end']);

        unset($_SESSION['date_start']);
        unset($_SESSION['date_end']);

        return $permissions;
    }

    protected function filterPermissionByStatuses($role = []):array {
        $result = [];
        $permissions = [];
        $statuses = explode(' ', $_SESSION['statuses']);

        foreach ($statuses as $statusId) {
            if($role['isAuthor']) {
                $permissions =  $this->permission->getPermission(0, '', $_COOKIE['user'], '', '', '', $statusId);
            } elseif($role['isDispatcher']) {
                $date = date('Y.m.d');
                $permissions =  $this->permission->getPermission(0, '', 0, '', $date, $date, $statusId);
            }

            foreach ($permissions as $permission) {
                $result[] = $permission;
            }
        }

        return $result;
    }

    protected function filterPermission($roles = []) {
        $permissionsFirst = [];
        $permissionsSecond = [];
        $permissions = [];

        if((isset($_SESSION['date_start']) && $_SESSION['date_start'] !== '') || (isset($_SESSION['date_end']) && $_SESSION['date_end'] !== '')) {
            $permissionsFirst = $this->filterPermissionByDates();
        }
        if(isset($_SESSION['statuses']) && $_SESSION['statuses'] !== '') {
            $permissionsSecond = $this->filterPermissionByStatuses($roles);
        }

        if(count($permissionsFirst) > count($permissionsSecond) && count($permissionsSecond) > 0) {
            foreach ($permissionsFirst as $item1) {
                foreach ($permissionsSecond as $item2) {
                    if($item1['id'] === $item2['id']) {
                        $permissions[] = $item1;
                    }
                }
            }
        } elseif(count($permissionsFirst) < count($permissionsSecond) && count($permissionsFirst) > 0) {
            foreach ($permissionsSecond as $item1) {
                foreach ($permissionsFirst as $item2) {
                    if ($item1['id'] === $item2['id']) {
                        $permissions[] = $item1;
                    }
                }
            }
        } elseif(count($permissionsFirst) > 0) {
            $permissions = $permissionsFirst;
        } else {
            $permissions = $permissionsSecond;
        }

        unset($_SESSION['filter']);

        return $permissions;
    }

    protected function getPermissions($roles = []):array {
        if(isset($_SESSION['filter'])) {
            $permissions = $this->filterPermission($roles);
        } elseif(isset($_SESSION['permission_search'])) {
            $permissions = $_SESSION['permission_search'];
            unset($_SESSION['permission_search']);
        } else {
            if($roles['isDispatcher']) {
                $date = date('Y.m.d');
                $permissions = $this->permission->getPermission(0, '', 0, '', $date, $date);
            } elseif($roles['isReplacementEngineer']) {
                $date = date('Y.m.d');
                $permissions = $this->permission->getPermission(0, '');
            } else {
                $permissions = $this->permission->getPermission(0, '', $_COOKIE['user']);
            }
        }

        return $this->setColorsToPermissions($permissions);
    }

    protected function searchPermissions($roles = []) {
        $_SESSION['search_info'] =  trim($_POST['search_info']);
        $search = '%' . trim($_POST['search_info']) . '%';

        if($roles['isAuthor']) {
            $permissions = $this->permission->getPermission(0, '', $_COOKIE['user'], $search);
        } else {
            $permissions = $this->permission->getPermission(0, '', 0, $search);
        }

        $_SESSION['permission_search'] = $permissions;
    }

    protected function getSearch():string {
        $search = '';

        if(isset($_SESSION['search_info'])) {
            $search = $_SESSION['search_info'];
            unset($_SESSION['search_info']);
        }

        return $search;
    }

    protected function getStatuses($roles = []):array {
        $result = [];

        if($roles['isDispatcher']) {
            $result = $this->getDispatcherStatuses();
        } elseif($roles['isAuthor']) {
            $result = $this->getAuthorStatuses();
        }

        if(isset($_SESSION['statuses'])) {
            $arr = explode(' ', $_SESSION['statuses']);

            foreach ($result as &$item) {
                if(in_array($item['id'], $arr)) {
                    $item['active'] = true;
                }
            }

            unset($_SESSION['statuses']);
        } else {
            foreach ($result as &$item) {
                $item['active'] = true;
            }
        }

        return $result;
    }

    protected function getDate($nameDate = ''):string {
        $result = '';

        if(isset($_SESSION[$nameDate])) {
            $result = $_SESSION[$nameDate];
        }

        return $result;
    }

    public function getIndexVarsToTwig() {
        $roles = $this->role->getRoles($_COOKIE['user']);
        $dateStart = $this->getDate('date_start');
        $dateEnd = $this->getDate('date_end');
        $message = 'Совпадений не найдено';
        $search = $this->getSearch();
        $permissions = $this->getPermissions($roles);
        //echo print_r($permissions);
        $statuses = $this->getStatuses($roles);

        if(isset($_POST['submit-masking'])){
            echo print_r($_POST);
            echo print_r($_POST['masking-langth']);
            

            //$this->protection->addEmployee($employee['user_id'], $_SESSION['idCurrentPermission'], $employee['type_person_id']);
        }


        if(isset($_POST['filter'])) {
            $this->setSessionsForFilter();
            $this->redirect('permission', '');
        } elseif(isset($_POST['search_info'])) {
            $this->searchPermissions($roles);
            $this->redirect('permission', '');
        }

        return ['permissions' => $permissions,
            'protections' => $this->protection->getProtectionsOfPermissionThisStatuses($_COOKIE['user']),
            'author' => $this->user->getUsers($_COOKIE['user'], '', 0, 0,  ''),
            'dates' => $this->date->getDates(0, $_COOKIE['user']),
            'responsiblesForPreparation' =>  $this->employee->getEmployee(2,0, 0),
            'responsiblesForExecute' => $this->employee->getEmployee(3, 0, 0),
            'responsiblesForControl' =>  $this->employee->getEmployee(4,0, 0),
            'typical_works' => $this->typicalWork->getTypicalWork(0, $_COOKIE['user']),
            'message' => $message,
            'search_info' => $search,
            'roles' => $roles,
            'statuses' => $statuses,
            'date_start' => $dateStart,
            'date_end' => $dateEnd
        ];
    }

    protected function setColorsToPermissions($permissions = []):array {
        foreach ($permissions as &$permission) {
            if($permission['status_id'] === 1) {
                $permission['color'] = 'violet';
            } elseif($permission['status_id'] === 2) {
                $permission['color'] = 'beige';
            } elseif($permission['status_id'] === 3) {
                $permission['color'] = 'blue';
            } elseif($permission['status_id'] === 4) {
                $permission['color'] = 'green';
            } elseif($permission['status_id'] === 5) {
                $permission['color'] = 'yellow';
            }
        }

        return $permissions;
    }

    public function delTypicalWork($id) {
        $this->typicalWork->delTypicalWork(0, $id);
    }

    public function delResponsible($idEmployee, $idTypePerson) {
        $this->employee->delEmployee($idEmployee, $_SESSION['idCurrentPermission'], $idTypePerson);
    }

    public function getAddVarsToTwig():array {
       if (isset($_REQUEST["id_responsible_for_preparation"])) {
            $this->employee->delEmployee($_REQUEST["id_responsible_for_preparation"], $_SESSION['idCurrentPermission'], 2);
            return ['ajax' => true];
        } else {
            $supervisor = $this->employee->getEmployee(5, $_SESSION['idCurrentPermission']);
            $roles = $this->role->getRoles($_COOKIE['user']);

            if(isset($supervisor[0])) {
                $supervisor = $supervisor[0];
            }

            return ['current_typical_works' => $this->typicalWork->getTypicalWork( $_SESSION['idCurrentPermission']),
                'current_dates' => $this->date->getDates($_SESSION['idCurrentPermission']),
                'permission' => $this->permission->getPermission($_SESSION['idCurrentPermission'])[0],
                'supervisorOfResponsibleForExecute' => $supervisor,
                'responsiblesForPreparation' => $this->employee->getEmployee(2, $_SESSION['idCurrentPermission']),
                'responsiblesForExecute' => $this->employee->getEmployee(3, $_SESSION['idCurrentPermission']),
                'responsiblesForControl' => $this->employee->getEmployee(4, $_SESSION['idCurrentPermission']),
                'roles' => $roles];
        }
    }
}