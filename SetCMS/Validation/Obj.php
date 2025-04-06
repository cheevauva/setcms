<?php

declare(strict_types=1);

namespace SetCMS\Validation;

class Obj extends Any
{

    public function val(): object
    {
        $this->validate();

        return $this->value;
    }
}
