<?php

declare(strict_types=1);

namespace Module\RAD01\Exception;

class RAD01EntitiesNotFoundException extends RAD01Exception
{
    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Записи не найдены';
}
