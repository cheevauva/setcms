<?php

declare(strict_types=1);

namespace SetCMS\Entity\Exception;

class EntityNotFoundException extends \Exception
{
    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
}
