<?php

declare(strict_types=1);

namespace Module\UserSession\Traits;

use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;
use Module\UserSession\UserSessionEntity;

trait UserSessionCallTrait
{

    public UserSessionEntity $userSession;

    public static function call(WithContainterInterface|ContainerInterface $container, UserSessionEntity $userSession): self
    {
        $self = self::new($container);
        $self->userSession = $userSession;
        $self->serve();

        return $self;
    }
}
