<?php

declare(strict_types=1);

namespace Module\User\Traits;

use Psr\Container\ContainerInterface;
use Module\User\Entity\UserEntity;

trait UserCallTrait
{

    public UserEntity $user;

    /**
     * @param ContainerInterface $container
     * @param UserEntity $user
     * @return static
     */
    public static function call(ContainerInterface $container, UserEntity $user): self
    {
        $self = self::new($container);
        $self->user = $user;
        $self->serve();

        return $self;
    }
}
