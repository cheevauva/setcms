<?php

declare(strict_types=1);

namespace SetCMS\Validation;

class Integer extends Any
{

    public function val(): int
    {
        $this->validate();

        return intval($this->value);
    }
}
