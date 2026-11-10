<?php

declare(strict_types=1);

namespace Module\Email\Traits;

use Psr\Container\ContainerInterface;
use Module\Email\Entity\EmailEntity;
use UUA\WithContainterInterface;

trait EmailCallTrait
{

    public EmailEntity $email;

    public static function call(WithContainterInterface|ContainerInterface $container, EmailEntity $email): self
    {
        $self = self::new($container);
        $self->email = $email;
        $self->serve();

        return $self;
    }
}
