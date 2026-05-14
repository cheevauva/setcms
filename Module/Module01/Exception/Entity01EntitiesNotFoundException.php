<?php

declare(strict_types=1);

namespace Module\Module01\Exception;

class Entity01EntitiesNotFoundException extends Entity01Exception
{
    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Записи не найдены';
}
