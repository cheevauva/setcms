<?php

declare(strict_types=1);

namespace Module\Email\Traits;

use Psr\Container\ContainerInterface;
use Module\Email\Entity\EmailEntity;

trait EmailCallTrait
{

    public EmailEntity $email;

    /**
     * @param ContainerInterface $container
     * @param EmailEntity $email
     * @return static
     */
    public static function call(ContainerInterface $container, EmailEntity $email): self
    {
        $self = self::new($container);
        $self->email = $email;
        $self->serve();

        return $self;
    }
}
