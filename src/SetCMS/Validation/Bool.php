<?php

declare(strict_types=1);

namespace SetCMS\Validation;

class Bool extends Any
{

    #[\Override]
    public function validate(): void
    {
        if ($this->notEmpty && !isset($this->value)) {
            throw new \Exception('');
        }
    }

    public function val(): bool
    {
        $this->validate();

        return boolval($this->value);
    }
}
