<?php

declare(strict_types=1);

namespace Module\Post\Traits;

use Psr\Container\ContainerInterface;
use Module\Post\Entity\PostEntity;

trait PostCallTrait
{

    public PostEntity $post;

    /**
     * @param ContainerInterface $container
     * @param PostEntity $post
     * @return static
     */
    public static function call(ContainerInterface $container, PostEntity $post): self
    {
        $self = self::new($container);
        $self->post = $post;
        $self->serve();

        return $self;
    }
}
