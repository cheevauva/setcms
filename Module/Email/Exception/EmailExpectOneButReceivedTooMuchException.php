<?php

declare(strict_types=1);

namespace Module\Email\Exception;

class EmailExpectOneButReceivedTooMuchException extends EmailException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
