<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\FactoryInterface;
use SetCMS\Module\Post\DAO\PostEntityDbMapper;
use SetCMS\Module\Post\PostConstants;
use SetCMS\Database\MainConnection;

trait PostEntityDbTrait
{

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = PostEntityDbMapper::factory($container->get(FactoryInterface::class));
        $this->table = PostConstants::TABLE_NAME;
        $this->db = $container->get(MainConnection::class);
    }

}
