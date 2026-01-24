<?php

declare(strict_types=1);

namespace UUA\Traits;

use UUA\Unit;
use UUA\Wrapper;

trait WrappingTrait
{

    use ContainerTrait;

    protected function wrapping(Unit $unit): Unit
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
