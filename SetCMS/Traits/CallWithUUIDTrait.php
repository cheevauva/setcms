<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use Psr\Container\ContainerInterface;
use SetCMS\UUID;

trait CallWithUUIDTrait
{

    public UUID $id;

    /**
     * @param ContainerInterface $container
     * @param UUID $id
     * @return static
     */
    public static function call(ContainerInterface $container, UUID $id): self
    {
        $self = self::new($container);
        $self->id = $id;
        $self->serve();

        return $self;
    }
}
