<?php

namespace models;

use widgets\permission\Permission;
use widgets\typicalwork\TypicalWork;

class TypeWorkModel extends AppModel
{
    protected $typicalWork;
    protected $permission;
    protected $permissionId = 0;

    public function __construct() {
        $this->typicalWork = new TypicalWork();
        $this->permission = new Permission();

        if(isset($_SESSION['idCurrentPermission'])) {
            $this->permissionId = $_SESSION['idCurrentPermission'];
        }
    }

    public function updateTypesWorks($untypicalWorks, $typesWorksId, $descriptionsTypesWorks) {
        $untypicalWorks = htmlspecialchars(trim($untypicalWorks));
        $permission = $this->permission->getPermission($this->permissionId)[0];
        $this->permission->updatePermission($this->permissionId, $permission['date_create'], $permission['description'], $permission['addition'],
                                            $permission['number'], $permission['subdivision_id'], $untypicalWorks);

        $this->typicalWork->delTypicalWork($this->permissionId);

        if($typesWorksId[0] !== '') {
            for ($i = 0; $i < count($typesWorksId); $i++) {
                $this->typicalWork->setTypicalWorks($this->permissionId, $typesWorksId[$i], $descriptionsTypesWorks[$i]);
            }
        }

        $this->redirect('permission', 'add');
    }

    public function getIndexArrForTwig():array {
        return ['typical_works' => $this->typicalWork->getTypicalWork(),
            'current_typical_works' => $this->typicalWork->getTypicalWork($this->permissionId),
            'untypical_work' => $this->permission->getPermission($this->permissionId)[0]['untypical_work']];
    }
}