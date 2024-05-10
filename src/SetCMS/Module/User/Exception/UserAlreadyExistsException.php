<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

class UserAlreadyExistsException extends UserException
{

    protected $message = "Пользователь уже существует";

}
