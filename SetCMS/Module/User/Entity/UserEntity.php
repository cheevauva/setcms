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

    public function newResetPasswordTicket(): void
    {
        $ticket = new UserResetPasswordTicketVO();
        $ticket->used = false;
        $ticket->code = new UUID();
        $ticket->dateCreated = new \DateTimeImmutable();

        $this->resetPasswordTicket = $ticket;
    }
}
