<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PageExpectOneButReceivedTooMuchException extends PageException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
