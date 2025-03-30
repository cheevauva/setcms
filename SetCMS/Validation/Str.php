<?php

declare(strict_types=1);

namespace SetCMS\Validation;

class Str extends Any
{

    public function val(): string
    {
        $this->validate();

        return strval($this->value);
    }
}
