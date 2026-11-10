<?php

declare(strict_types=1);

namespace Module\User\Traits;

use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;
use Module\User\Entity\UserEntity;

trait UserCallTrait
{

    public UserEntity $user;

    public static function call(WithContainterInterface|ContainerInterface $container, UserEntity $user): self
    {
        $self = self::new($container);
        $self->user = $user;
        $self->serve();

        return $self;
    }
}
