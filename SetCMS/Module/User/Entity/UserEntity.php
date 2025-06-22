<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Entity;

use SetCMS\Module\User\Enum\UserRoleEnum;

class UserEntity extends \SetCMS\Common\Entity\Entity
{

    public string $email;
    public string $username;
    public string $password;
    public UserRoleEnum $role = UserRoleEnum::GUEST;
}
