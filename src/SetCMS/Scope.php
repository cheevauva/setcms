<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\Contract\Arrayable;
use SetCMS\Contract\Satisfiable;
use SetCMS\Contract\Hydratable;

abstract class Scope implements Hydratable, Satisfiable, Arrayable
{

    private array $messages = [];

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function withMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    public function withMessage(mixed $message): void
    {
        $this->messages[] = $message;
    }

    public function hasMessages(): bool
    {
        return !empty($this->messages);
    }

    public function satisfy(): \Iterator
    {
        yield from [];
    }

    public function from(object $object): void
    {
        
    }

    public function to(object $object): void
    {
        
    }

    public function toArray(): array
    {
        return [];
    }

}
