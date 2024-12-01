<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Exception;

class UserException extends Exception
{

    public ?UserEntity $user = null;

}
