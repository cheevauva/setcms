<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Entity;

use SetCMS\Module\User\Enum\UserRoleEnum;

class UserEntity extends \SetCMS\Common\Entity\Entity
{

    public string $username;
    public string $password;
    public UserRoleEnum $role = UserRoleEnum::GUEST;

    public function withRole(UserRoleEnum $role): void
    {
        $this->role = $role;
    }

    public function hasRole(UserRoleEnum $role): bool
    {
        return $role === $this->role;
    }

    public function hasRoleAsString(string $role): bool
    {
        return UserRoleEnum::from($role) === $this->role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(UserRoleEnum::ADMIN);
    }
}
