<?php

declare(strict_types=1);

namespace Module\UserSession\Traits;

use Psr\Container\ContainerInterface;
use Module\UserSession\UserSessionEntity;

trait UserSessionCallTrait
{

    public UserSessionEntity $userSession;

    /**
     * @param ContainerInterface $container
     * @param UserSessionEntity $userSession
     * @return static
     */
    public static function call(ContainerInterface $container, UserSessionEntity $userSession): self
    {
        $self = self::new($container);
        $self->userSession = $userSession;
        $self->serve();

        return $self;
    }
}
