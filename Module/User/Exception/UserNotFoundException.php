<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserNotFoundException extends UserException
{

    /**
     * @var string
     */
    protected $message = 'Пользователь не найден';
}
