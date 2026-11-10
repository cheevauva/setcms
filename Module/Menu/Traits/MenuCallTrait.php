<?php

declare(strict_types=1);

namespace Module\Menu\Traits;

use Psr\Container\ContainerInterface;
use Module\Menu\Entity\MenuEntity;
use UUA\WithContainterInterface;
trait MenuCallTrait
{

    public MenuEntity $menu;

    public static function call(WithContainterInterface|ContainerInterface $container, MenuEntity $menu): self
    {
        $self = self::new($container);
        $self->menu = $menu;
        $self->serve();

        return $self;
    }
}
