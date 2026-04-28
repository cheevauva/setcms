<?php

declare(strict_types=1);

namespace Module\Menu\Traits;

use Psr\Container\ContainerInterface;
use Module\Menu\Entity\MenuEntity;

trait MenuCallTrait
{

    public MenuEntity $menu;

    /**
     * @param ContainerInterface $container
     * @param MenuEntity $menu
     * @return static
     */
    public static function call(ContainerInterface $container, MenuEntity $menu): self
    {
        $self = self::new($container);
        $self->menu = $menu;
        $self->serve();

        return $self;
    }
}
