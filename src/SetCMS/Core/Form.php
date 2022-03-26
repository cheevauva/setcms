<?php

declare(strict_types=1);

namespace SetCMS\Core;

use SetCMS\Core\ApplyInterface;
use SetCMS\Core\Form\Message;
use Exception;

class Form implements ApplyInterface
{

    private ?Form $parent = null;

    public function isValid(): bool
    {
        
    }

    public function apply(object $object): void
    {
        if ($object instanceof Form) {
            $this->parent = $object;
        }

        if ($object instanceof Exception) {
            $this->messages[] = new Message($object->getMessage());
        }
    }

    public function fromArray(array $array): void
    {
        
    }

}
