<?php

declare(strict_types=1);

namespace SetCMS\Validation;

class Flt extends Any
{

    public function val(): float
    {
        $this->validate();

        return floatval($this->value);
    }
}
