<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\Contract\Arrayable;
use SetCMS\Contract\Satisfiable;
use SetCMS\Contract\Hydratable;
use SetCMS\Scope\ScopeMessageStorage;

abstract class Scope implements Hydratable, Satisfiable, Arrayable
{

    public ?array $messages = null;

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
