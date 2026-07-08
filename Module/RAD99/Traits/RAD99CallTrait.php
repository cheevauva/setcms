<?php

declare(strict_types=1);

namespace Module\RAD99\Traits;

use Psr\Container\ContainerInterface;
use Module\RAD99\Entity\RAD99Entity;

trait RAD99CallTrait
{

    public RAD99Entity $rad99;

    /**
     * @param ContainerInterface $container
     * @param RAD99Entity $rad99
     * @return static
     */
    public static function call(ContainerInterface $container, RAD99Entity $rad99): self
    {
        $self = self::new($container);
        $self->rad99 = $rad99;
        $self->serve();

        return $self;
    }
}
