<?php

namespace models;

class AppModel
{
    public function redirect($controller, $event = '') {
        $location = 'Location: ' . HTTP . '://' . '/' . NAME_WEBSITE . '/' . $controller . '/' . $event;
        header($location);
        die();
    }
}