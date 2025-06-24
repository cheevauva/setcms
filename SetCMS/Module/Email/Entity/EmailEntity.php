<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Entity;

use SetCMS\Common\Entity\Entity;
use SetCMS\Module\Email\Enum\EmailStatusEnum;

class EmailEntity extends Entity
{

    public string $subject;
    public string $from;
    public string $to;
    public string $body;
    public ?\DateTimeImmutable $dateSent = null;
    public EmailStatusEnum $status = EmailStatusEnum::_New;
}
