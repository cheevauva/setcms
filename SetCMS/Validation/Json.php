<?php

declare(strict_types=1);

namespace SetCMS\Validation;

use SetCMS\Validation\Exception\ValidationJsonInvalidException;

class Json extends Any
{

    protected bool $asArray = false;

    public function asArray(): self
    {
        $this->asArray = true;

        return $this;
    }

    public function val(): mixed
    {
        $this->validate();

        $value = json_decode($this->value, true);

        if ($this->asArray && $this->messages->count()) {
            return [];
        }

        if ($this->asArray && !is_array($value)) {
            $this->throw(new ValidationJsonInvalidException('Указанный json должен содержать объект'));
            return [];
        }

        return $value;
    }

    #[\Override]
    public function validate(): void
    {
        parent::validate();

        if (!json_validate($this->value)) {
            $this->throw(new ValidationJsonInvalidException());
        }
    }
}
