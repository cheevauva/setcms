<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\FactoryInterface;
use SetCMS\Database\MainConnection;
use SetCMS\Module\User\DAO\UserEntityDbMapper;
use SetCMS\Module\User\UserContstants;

trait UserEntityDbTrait
{

    private FactoryInterface $factory;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(FactoryInterface::class);
        $this->mapper = UserEntityDbMapper::factory($this->factory);
        $this->table = UserContstants::TABLE_NAME;
        $this->db = $container->get(MainConnection::class);
    }

}
