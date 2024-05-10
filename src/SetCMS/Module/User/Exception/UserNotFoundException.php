<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

class UserNotFoundException extends UserException
{

    protected $message = "Пользователь не найден";

}
