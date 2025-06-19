<?php

declare(strict_types=1);

namespace SetCMS\Validation;

class UUID extends Any
{

    public function val(): \SetCMS\UUID
    {
        $this->validate();

        return new \SetCMS\UUID($this->value);
    }
}
