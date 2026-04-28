<?php

declare(strict_types=1);

namespace Module\UserResetToken\Traits;

use Psr\Container\ContainerInterface;
use Module\UserResetToken\Entity\UserResetTokenEntity;

trait UserResetTokenCallTrait
{

    public UserResetTokenEntity $userResetToken;

    /**
     * @param ContainerInterface $container
     * @param UserResetTokenEntity $userToken
     * @return static
     */
    public static function call(ContainerInterface $container, UserResetTokenEntity $userToken): self
    {
        $self = self::new($container);
        $self->userResetToken = $userToken;
        $self->serve();

        return $self;
    }
}
