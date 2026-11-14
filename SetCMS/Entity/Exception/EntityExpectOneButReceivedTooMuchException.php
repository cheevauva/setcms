<?php

declare(strict_types=1);

namespace SetCMS\Entity\Exception;

class EntityExpectOneButReceivedTooMuchException extends \Exception
{
    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
