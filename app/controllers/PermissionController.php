<?php

namespace controllers;

use core\Twig;
use models\PermissionModel;

class PermissionController extends AppController
{
    private $model;

    public function indexAction() {
        $this->checkAuthorization();
        $this->setMeta('Разрешения');
        $this->model = new PermissionModel();

        if(isset($_POST['del-permission'])) {
            $this->model->delPermission($_POST['id']);
        }elseif(isset($_POST['edit-permission'])) {
            $this->model->editPermission($_POST['id']);
        } elseif(isset($_POST['create-permission-by'])) {
            $this->model->createPermissionById($_POST['id']);
        } elseif(isset($_POST['open-permission'])) {
            $this->model->addStatusOfPermission(4, $_POST['comment'], $_POST['date'], $_POST['time']);
        } elseif(isset($_POST['pause-permission'])) {
            $this->model->addStatusOfPermission(5, $_POST['comment'], $_POST['date'], $_POST['time']);
        } elseif(isset($_POST['close-permission'])) {
            $this->model->addStatusOfPermission(6, $_POST['comment'], $_POST['date'], $_POST['time']);
        }

        $this->setIndexVarsToTwig();
    }

    public function addAction() {
        $this->checkAuthorization();
        $this->setMeta('Добавить разрешение');
        $this->model = new PermissionModel();

        if (isset($_REQUEST["id_type_work"])) {
            $this->model->delTypicalWork($_REQUEST["id_type_work"]);
        } elseif(isset($_REQUEST['id_responsible'])) {
            $this->model->delResponsible($_REQUEST['id_responsible'], $_REQUEST['id_type_person']);
        } elseif(isset($_POST['update-permission'])) {
            $this->model->updatePermission($_POST['description'], $_POST['addition']);
        } elseif(isset($_POST['create-permission'])) {
            $this->model->createPermission();
        } elseif(isset($_POST['edit-number'])) {
            $this->model->updateNumber($_POST['first_number'], $_POST['second_number']);
        }

        $this->setAddVarsToTwig();
    }

    public function setAddVarsToTwig() {
        $arr = $this->model->getAddVarsToTwig();
        Twig::addVarsToArrayOfRender($arr);
    }

    public function setIndexVarsToTwig(){
        $arr = $this->model->getIndexVarsToTwig();
        Twig::addVarsToArrayOfRender($arr);
    }
}