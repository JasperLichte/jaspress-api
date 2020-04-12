<?php

namespace api\actions\admin\calendar;

use api\actions\admin\AdminAction;
use api\ApiResponse;
use calendar\Item;

class EditCalendarEntryAction extends AdminAction
{

    /** @var Item */
    private $item;

    public function __construct()
    {
        parent::__construct();

        if ($this->req->issetPost('id')) {
            $this->item = (new Item())->deserialize($this->req->getAllPost());
        }
    }

    public function run(): ApiResponse
    {
        if ($this->item == null || $this->item->isEmpty()) {
            return $this->res->setErrorMessage('Entry cannot be empty!')->status(400);
        }

        $this->item->replace($this->db);

        return $this->res->setSuccessMessage('Entry edited');
    }

}
