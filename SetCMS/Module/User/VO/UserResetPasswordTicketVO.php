<?php

declare(strict_types=1);

namespace SetCMS\Module\User\VO;

use SetCMS\UUID;

class UserResetPasswordTicketVO
{

    public UUID $code;
    public \DateTimeImmutable $dateCreated;
    public bool $used = false;
}
