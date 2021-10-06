<?php

namespace SetCMS\Module\Ordinary\OrdinaryModel;

class OrdinaryModelError extends \SetCMS\Model
{

    public string $message;
    public string $trace;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
