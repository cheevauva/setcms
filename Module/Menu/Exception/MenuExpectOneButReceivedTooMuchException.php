<?php

declare(strict_types=1);

namespace Module\Menu\Exception;

class MenuExpectOneButReceivedTooMuchException extends MenuException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
