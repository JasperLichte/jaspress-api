<?php

require_once(__DIR__ . '/../../server/base.php');

use api\actions\auth\RegisterAction;

echo (new RegisterAction())->run();
