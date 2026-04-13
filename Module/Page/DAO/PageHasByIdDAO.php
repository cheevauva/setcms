<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\UUID;

class PageHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityHasByIdDAOTrait;
    use PageCommonDAO;

    /**
     * @param ContainerInterface $container
     * @param UUID $id
     * @return static
     */
    public static function call(ContainerInterface $container, UUID $id): self
    {
        $self = self::new($container);
        $self->id = $id;
        $self->serve();

        return $self;
    }
}
