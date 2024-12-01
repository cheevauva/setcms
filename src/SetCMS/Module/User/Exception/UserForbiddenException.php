<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

use SetCMS\Application\Contract\ContractForbidden;

class UserForbiddenException extends UserException implements ContractForbidden
{

    protected $message = "Доступ запрещён";

}
