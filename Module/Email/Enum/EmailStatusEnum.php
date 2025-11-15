<?php

declare(strict_types=1);

namespace Module\Email\Enum;

enum EmailStatusEnum: string
{

    case _New = 'new';
    case Sending = 'sending';
    case Sent = 'sent';
    case Error = 'error';
}
