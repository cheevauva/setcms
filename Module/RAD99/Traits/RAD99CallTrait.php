<?php

declare(strict_types=1);

namespace Module\RAD99\Traits;

use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;
use Module\RAD99\Entity\RAD99Entity;

trait RAD99CallTrait
{

    public RAD99Entity $rad99;

    public static function call(WithContainterInterface|ContainerInterface $container, RAD99Entity $rad99): self
    {
        $self = self::new($container);
        $self->rad99 = $rad99;
        $self->serve();

        return $self;
    }
}
