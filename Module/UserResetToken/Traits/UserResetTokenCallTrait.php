<?php

declare(strict_types=1);

namespace Module\UserResetToken\Traits;

use Psr\Container\ContainerInterface;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use UUA\WithContainterInterface;

trait UserResetTokenCallTrait
{

    public UserResetTokenEntity $userResetToken;

    public static function call(WithContainterInterface|ContainerInterface $container, UserResetTokenEntity $userToken): self
    {
        $self = self::new($container);
        $self->userResetToken = $userToken;
        $self->serve();

        return $self;
    }
}
