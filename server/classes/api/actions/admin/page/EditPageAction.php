<?php

namespace api\actions\admin\page;

use api\ApiResponse;;

use util\exceptions\EmptyMemberException;
use util\exceptions\LogicException;

class EditPageAction extends PageAction
{

    public function run(): ApiResponse
    {
        if (empty($this->slug) || empty($this->content)) {
            return $this->res->setErrorMessage('Page cannot be empty!')->status(400);
        }

        try {
            $this->page->save($this->db, true);
        } catch(LogicException | EmptyMemberException $e) {
            return $this->res->exception($e);
        }

        return $this->res->setSuccessMessage('Page edited');
    }

}
