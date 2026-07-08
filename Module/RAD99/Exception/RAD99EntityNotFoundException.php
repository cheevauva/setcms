<?php

declare(strict_types=1);

namespace Module\RAD99\Exception;

class RAD99EntityNotFoundException extends RAD99Exception
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
}
