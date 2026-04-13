<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\UUID;

class UserSessionHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityHasByIdDAOTrait;
    use UserSessionGenericDAO;

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
