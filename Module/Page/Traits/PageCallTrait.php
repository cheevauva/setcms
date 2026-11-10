<?php

declare(strict_types=1);

namespace Module\Page\Traits;

use Psr\Container\ContainerInterface;
use Module\Page\Entity\PageEntity;
use UUA\WithContainterInterface;

trait PageCallTrait
{

    public PageEntity $page;

    public static function call(WithContainterInterface|ContainerInterface $container, PageEntity $page): self
    {
        $self = self::new($container);
        $self->page = $page;
        $self->serve();

        return $self;
    }
}
