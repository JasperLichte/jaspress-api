<?php

namespace api\actions\page;

use api\actions\Action;
use api\actions\admin\page\PageAction;
use api\ApiResponse;
use content\models\Page;
use permissions\AlwaysAllowedPermission;
use permissions\Permission;

class GetPageAction extends Action
{

    /** @var string */
    private $slug;

    public function __construct()
    {
        parent::__construct();

        if ($this->req->issetGet(PageAction::GET_PAGE_KEY)) {
            $this->slug = $this->req->getGet(PageAction::GET_PAGE_KEY);
        }
    }

    public function run(): ApiResponse
    {
        if (empty($this->slug)) {
            return $this->res->setErrorMessage('Slug cannot be empty!')->status(400);
        }

        $page = Page::load($this->db, $this->slug);
        if ($page == null || $page->isEmpty()) {
            return $this->res->setErrorMessage('Page not found')->status(404);
        }

        return $this->res->withData(['page' => $page]);
    }

    public function permission(): Permission
    {
        return new AlwaysAllowedPermission();
    }

}
