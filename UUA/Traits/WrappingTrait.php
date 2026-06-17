<?php

declare(strict_types=1);

namespace UUA\Traits;

use UUA\UnitInterface;
use UUA\Wrapper;

trait WrappingTrait
{

    use ContainerTrait;

    protected function wrapping(UnitInterface $unit): UnitInterface
    {
        $decorators = $this->container->get('wrappers')[$unit::class] ?? null;
  
        if (empty($decorators)) {
            return $unit;
        }

        $prev = $unit;

        foreach ($decorators as $decorator) {
            $next = Wrapper::as($decorator::new($this->container));
            $next->rootUnit = $unit;
            $next->nextUnit = $prev;

            $prev = $next;
        }
        
        return $next ?? $unit;
    }
}
