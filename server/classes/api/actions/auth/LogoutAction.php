<?php

namespace api\actions\auth;


use api\actions\Action;
use api\ApiResponse;
use permissions\AlwaysAllowedPermission;
use permissions\Permission;

class LogoutAction extends Action
{

    public function run(): ApiResponse
    {
        if ($this->req->getUser() !== null) {
            $this->req->getUser()->logout();
        }

        return $this->res->setSuccessMessage('Logged out');
    }

    public function permission(): Permission
    {
        return new AlwaysAllowedPermission();
    }

}
