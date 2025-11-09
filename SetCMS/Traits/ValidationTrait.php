<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use SplObjectStorage;
use SetCMS\Validation\Validation;

trait ValidationTrait
{

    protected function validation(mixed $data): Validation
    {
        if (!is_array($data)) {
            throw new \Exception('Ожидался array, а пришел ' . gettype($data));
        }

        return new Validation($data, $this->getMessages());
    }

    abstract public function getMessages(): SplObjectStorage;
}
