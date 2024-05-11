<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

use SetCMS\Contract\Forbidden;

class UserForbiddenException extends UserException implements Forbidden
{

    protected $message = "Доступ запрещён";

    public function label(): string
    {
        return 'setcms.user.forbidden';
    }

}
