<?php

declare(strict_types=1);

namespace SetCMS\Validation\Exception;

class ValidationJsonInvalidException extends \Exception
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Значение должно быть валидной json строкой';
}
