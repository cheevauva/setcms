<?php

declare(strict_types=1);

namespace SetCMS\Controller\Exception;

class ControllerUnitMustBeInstanceofUnitException extends Exception
{

    public function __construct()
    {
        parent::__construct('unit must be extends Unit');
    }
}
