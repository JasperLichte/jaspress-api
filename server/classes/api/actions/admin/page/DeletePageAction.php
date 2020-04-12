<?php

namespace api\actions\admin\page;

use api\ApiResponse;
use content\models\Page;

class DeletePageAction extends PageAction
{

    public function run(): ApiResponse
    {
        Page::delete($this->db, $this->slug);

        return $this->res->setSuccessMessage('Page deleted');
    }

}
