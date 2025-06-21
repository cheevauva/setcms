<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Entity;

use SetCMS\Module\User\Enum\UserRoleEnum;
use SetCMS\Module\User\VO\UserResetPasswordTicketVO;
use SetCMS\UUID;

class UserEntity extends \SetCMS\Common\Entity\Entity
{

    public string $email;
    public string $username;
    public string $password;
    public ?UserResetPasswordTicketVO $resetPasswordTicket = null;
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

    public function newResetPasswordTicket(): void
    {
        $ticket = new UserResetPasswordTicketVO();
        $ticket->used = false;
        $ticket->code = new UUID();
        $ticket->dateCreated = new \DateTimeImmutable();

        $this->resetPasswordTicket = $ticket;
    }
}
