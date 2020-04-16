<?php

namespace api\actions\page\group;

use api\actions\Action;
use api\ApiResponse;
use content\group\PageGroup;
use permissions\AlwaysAllowedPermission;
use permissions\Permission;

class GetPageGroupAction extends Action
{

    /** @var string*/
    private $slug = null;

    public function __construct()
    {
        parent::__construct();

        if ($this->req->issetGet('group')) {
            $this->slug = $this->req->getGet('group');
        }
    }

    public function run(): ApiResponse
    {
        if (empty($this->slug)) {
            return $this->res->setErrorMessage('Parameter "group" cannot be empty!')->status(400);
        }

        return $this->res->withData([
            'group' => PageGroup::load($this->db, $this->slug),
        ]);
    }

    public function permission(): Permission
    {
        return new AlwaysAllowedPermission();
    }

}
