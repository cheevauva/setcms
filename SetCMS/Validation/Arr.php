<?php

declare(strict_types=1);

namespace SetCMS\Validation;

class Arr extends Any
{

    public function val(): array
    {
        $this->validate();

        return (array) $this->value;
    }
}
