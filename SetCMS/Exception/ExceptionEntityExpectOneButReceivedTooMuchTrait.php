<?php

declare(strict_types=1);

namespace SetCMS\Exception;

trait ExceptionEntityExpectOneButReceivedTooMuchTrait
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
