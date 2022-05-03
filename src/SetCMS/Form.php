<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\ApplyInterface;
use SetCMS\Form\FormMessageStorage;
use SetCMS\Form\Message\FormMessage;
use SetCMS\Form\Message\FormMessagePopulate;
use SetCMS\Servant\ArrayPropertyHydratorSevant;

class Form implements ApplyInterface
{

    private ?Form $parent = null;
    private FormMessageStorage $messages;

    public function __construct()
    {
        $this->messages = new FormMessageStorage;
    }

    public function valid(): bool
    {
        return $this->messages->count() === 0;
    }

    public function apply(object $object): void
    {
        if ($object instanceof Form) {
            $this->parent = $object;
        }

        if ($object instanceof \Throwable) {
            $this->apply(new FormMessage($object->getMessage(), get_class($object)));
        }

        if ($object instanceof FormMessage) {
            $this->messages->attach($object);
            $this->parent ? $this->parent->apply($object) : null;
        }
    }

    private function resetMessages()
    {
        foreach ($this->messages as $message) {
            if ($message instanceof FormMessagePopulate) {
                $this->messages->detach($message);
            }
        }
    }

    public function from(object $object): void
    {
        
    }

    public function to(object $object): void
    {
        
    }

    public function fromArray(array $array): void
    {
        $hydrator = new ArrayPropertyHydratorSevant;
        $hydrator->array = $array;
        $hydrator->object = $this;
        $hydrator->serve();
        
        foreach ($hydrator->messages as $message) {
            $this->apply(new FormMessagePopulate(...$message));
        }
    }

    public function getMessages(): array
    {
        $messages = [];

        foreach ($this->messages as $message) {
            if ($message instanceof FormMessage) {
                $messages[] = $message->toArray();
            }
        }

        return $messages;
    }

    public function toArray(): array
    {
        return [];
    }

}
