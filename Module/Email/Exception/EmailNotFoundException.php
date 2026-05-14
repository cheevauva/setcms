<?php

declare(strict_types=1);

namespace Module\Email\Exception;

class EmailNotFoundException extends EmailException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
}
