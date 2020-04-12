<?php

namespace api\actions\file;


use api\actions\Action;
use api\ApiResponse;
use permissions\AlwaysAllowedPermission;
use permissions\Permission;
use util\models\File;

class ShowFileAction extends Action
{

    /** @var int|null */
    private $id = null;

    public function __construct()
    {
        parent::__construct();

        if ($this->req->issetGet('i')) {
            $this->id = (int)$this->req->getGet('i');
        }
    }

    public function run(): ApiResponse
    {
        if ($this->id == null) {
            return $this->res->setErrorMessage('id cannot be empty!')->status(400);
        }

        $file = File::load($this->db, $this->id);
        if ($file == null) {
            return $this->res->status(500);
        }

        return $this->res->asFile($file);
    }

    public function permission(): Permission
    {
        return new AlwaysAllowedPermission();
    }
}
