<?php

namespace api\actions\admin\settings;

use api\actions\admin\AdminAction;
use api\ApiResponse;
use settings\Settings;

class ResetSettingAction extends AdminAction
{

    public function run(): ApiResponse
    {
        $key = ($this->req->issetGet('key') ? $this->req->getGet('key') : '');
        if (empty($key)) {
            return $this->res->setErrorMessage('Parameter "key" cannot be empty')->status(400);
        }

        $setting = Settings::getInstance($this->db)->get($key);
        if ($setting === null) {
            return $this->res->setErrorMessage('Invalid key')->status(400);
        }

        $setting::delete($this->db, $key);

        return  $this->res->setSuccessMessage('Setting ' . $key . ' removed');
    }

}
