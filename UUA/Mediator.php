<?php

declare(strict_types=1);

namespace UUA;

abstract class Mediator extends Unit
{

    use Traits\BuildTrait;
    use Traits\ContainerTrait;
    use Traits\EventDispatcherTrait;
}
