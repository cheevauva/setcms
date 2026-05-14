<?php

declare(strict_types=1);

namespace Module\Module01\Exception;

class Entity01sNotFoundException extends Entity01Exception
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
}
