<?php

declare(strict_types=1);

namespace SetCMS\Validation\Exception;

class ValidationNotEmptyException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Поле должно быть заполнено';
}
