<?php

declare(strict_types=1);

namespace Module\User\Exception;

use Module\User\Entity\UserEntity;
use SetCMS\Exception;

class UserException extends Exception
{

    public ?UserEntity $user = null;
}
