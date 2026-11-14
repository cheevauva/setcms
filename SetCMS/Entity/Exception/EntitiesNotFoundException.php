<?php

declare(strict_types=1);

namespace SetCMS\Entity\Exception;

class EntitiesNotFoundException extends \Exception
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Записи не найдены';
}
