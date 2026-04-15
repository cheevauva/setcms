<?php

declare(strict_types=1);

namespace Module\Page\Traits;

use Psr\Container\ContainerInterface;
use Module\Page\Entity\PageEntity;

trait PageCallTrait
{

    public PageEntity $page;

    /**
     * @param ContainerInterface $container
     * @param PageEntity $page
     * @return static
     */
    public static function call(ContainerInterface $container, PageEntity $page): self
    {
        $self = self::new($container);
        $self->page = $page;
        $self->serve();

        return $self;
    }
}
