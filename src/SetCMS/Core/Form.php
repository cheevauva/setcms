<?php

declare(strict_types=1);

namespace SetCMS\Core;

use SetCMS\Core\ApplyInterface;
use SetCMS\Core\Form\FormMessage;
use Exception;

class Form implements ApplyInterface
{

    private ?Form $parent = null;
    private SplObjectStorage $messages;

    public function __construct()
    {
        $this->messages = new \SplObjectStorage;
    }

    public function isValid(): bool
    {
        return true;
    }

    public function apply(object $object): void
    {
        if ($object instanceof Form) {
            $this->parent = $object;
        }

        if ($object instanceof Exception) {
            $this->apply(new FormMessage($object->getMessage(), get_class($object)));
        }

        if ($object instanceof FormMessage) {
            $this->messages->attach($object);
        }
    }

    public function fromArray(array $array): void
    {
        
    }

}
