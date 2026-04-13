<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\UUID;

class PostHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityHasByIdDAOTrait;
    use PostCommonDAO;

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
