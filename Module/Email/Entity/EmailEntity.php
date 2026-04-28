<?php

declare(strict_types=1);

namespace Module\Email\Entity;

use SetCMS\Entity\EntityBasic;
use Module\Email\Enum\EmailStatusEnum;

class EmailEntity extends EntityBasic
{

    public string $subject;
    public string $from;
    public string $to;
    public string $body;
    public ?\DateTimeImmutable $dateSent = null;
    public EmailStatusEnum $status = EmailStatusEnum::_New;
}
