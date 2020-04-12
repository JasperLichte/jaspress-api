<?php

namespace api\actions\admin\page;

use api\ApiResponse;
use util\exceptions\EmptyMemberException;
use util\exceptions\LogicException;

class NewPageAction extends PageAction
{

    public function run(): ApiResponse
    {
        if ($this->page === null || $this->page->isEmpty()) {
            return $this->res->setErrorMessage('Page cannot be empty!')->status(400);
        }

        try {
            $this->page->save($this->db);
        } catch (EmptyMemberException | LogicException $e) {
            return $this->res->exception($e);
        }

        return $this->res->setSuccessMessage('Page saved');
    }

}
