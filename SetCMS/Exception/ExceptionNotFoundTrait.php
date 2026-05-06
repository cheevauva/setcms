<?php

declare(strict_types=1);

namespace SetCMS\Exception;

trait ExceptionNotFoundTrait
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
}
