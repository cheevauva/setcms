<?php

declare(strict_types=1);

namespace SetCMS\Validation\Exception;

class ValidationNotEmptyException extends \Exception
{

    public function __construct()
    {
        parent::__construct('Поле должно быть заполнено');
    }
}
