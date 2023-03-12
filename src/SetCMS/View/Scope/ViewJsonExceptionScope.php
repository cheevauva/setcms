<?php

declare(strict_types=1);

namespace SetCMS\View\Scope;

use SetCMS\Scope;
use SetCMS\Exception;

class ViewJsonExceptionScope extends Scope
{

    protected array $data = [];

    public function from(object $object): void
    {
        if ($object instanceof \Throwable) {
            if ($object instanceof Exception) {
                $this->data = $object->placeholders();
                $this->messages[] = $object->label();
            } else {
                $this->messages[] = [
                    $object->getMessage(),
                ];
            }
        }
    }

    public function toArray(): array
    {
        return $this->data;
    }

}
