<?php

declare(strict_types=1);

namespace UUA;

class SymbiontCustomizer extends Symbiont
{

    protected object $master;

    public function __construct(object $master)
    {
        $this->master = $master;
    }

    public function from(object $object): void
    {
        
    }

    public function to(object $object): void
    {
        
    }

    public function catch(\Exception $object): void
    {
        throw new $object;
    }
}
