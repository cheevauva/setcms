<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserForbiddenException extends UserException
{

    /**
     * @var string
     */
    protected $message = 'Доступ запрещён';
}
