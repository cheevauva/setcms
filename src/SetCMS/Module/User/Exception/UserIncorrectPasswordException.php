<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

class UserIncorrectPasswordException extends UserException
{

    protected string $message = "Неверный пароль пользователя";

}
