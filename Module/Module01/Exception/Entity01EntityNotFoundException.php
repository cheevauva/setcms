<?php

declare(strict_types=1);

namespace Module\Module01\Exception;

class Entity01EntityNotFoundException extends Entity01Exception
{
    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
    
}
