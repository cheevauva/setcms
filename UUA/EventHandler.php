<?php

declare(strict_types=1);

namespace UUA;

use UUA\DAO;
use UUA\Servant;

class EventHandler extends Symbiont
{

    protected DAO|Servant $master;

    public function __construct(DAO|Servant $master)
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
