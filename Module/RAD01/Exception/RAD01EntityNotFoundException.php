<?php

declare(strict_types=1);

namespace Module\RAD01\Exception;

class RAD01EntityNotFoundException extends RAD01Exception
{
    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
    
}
