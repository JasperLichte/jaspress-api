<?php

namespace api;


use util\interfaces\Enum;

abstract class ResponseFormat extends Enum
{

    public const JSON = 'application/json';
    public const FILE = 'FILE';

}
