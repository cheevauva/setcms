<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use SplObjectStorage;
use SetCMS\Validation\Validation;

trait TraitsValidation
{

    /**
     * @var SplObjectStorage<\Throwable|object, mixed>
     */
    protected SplObjectStorage $messages;

    /**
     * @param array<string, mixed> $data
     * @return Validation
     */
    protected function validation(array $data): Validation
    {
        return new Validation($data, $this->messages);
    }
}
