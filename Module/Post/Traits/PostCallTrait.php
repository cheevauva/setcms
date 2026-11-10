<?php

declare(strict_types=1);

namespace Module\Post\Traits;

use Psr\Container\ContainerInterface;
use Module\Post\Entity\PostEntity;
use UUA\WithContainterInterface;

trait PostCallTrait
{

    public PostEntity $post;

    public static function call(WithContainterInterface|ContainerInterface $container, PostEntity $post): self
    {
        $self = self::new($container);
        $self->post = $post;
        $self->serve();

        return $self;
    }
}
