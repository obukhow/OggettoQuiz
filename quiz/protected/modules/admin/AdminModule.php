<?php

class AdminModule extends CWebModule
{
    public function init()
    {
        $this->setImport(array(
            'admin.controllers.*',
            'admin.models.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        }
        else
            return false;
    }
}
