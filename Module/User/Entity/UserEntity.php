<?php

declare(strict_types=1);

namespace Module\User\Entity;

use Module\User\Enum\UserRoleEnum;

class UserEntity extends \SetCMS\Entity\Entity
{

    public string $email;
    public string $username;
    public string $password;
    public UserRoleEnum $role = UserRoleEnum::GUEST;
}
