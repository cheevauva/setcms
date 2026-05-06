<?php

declare(strict_types=1);

namespace SetCMS\Exception;

trait ExceptionEntitiesNotFoundTrait
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Записи не найдены';
}
