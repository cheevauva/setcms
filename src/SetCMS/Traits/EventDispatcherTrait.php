<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use Psr\EventDispatcher\EventDispatcherInterface;

trait EventDispatcherTrait
{

    use DITrait;

    private function eventDispatcher(): EventDispatcherInterface
    {
        return $this->container->get(EventDispatcherInterface::class);
    }

}
