<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserNotFoundException extends UserException
{

    public function __construct()
    {
        parent::__construct('Пользователь не найден');
    }
}
