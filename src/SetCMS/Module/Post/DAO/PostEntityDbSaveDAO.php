<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Core\Entity\DAO\EntityDbSaveDAO;
use SetCMS\Module\Post\PostEntityDbMapper;
use SetCMS\Module\Post\PostConstants;
use SetCMS\FactoryInterface;
use SetCMS\Database\MainConnection;

class PostEntityDbSaveDAO extends EntityDbSaveDAO
{

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = PostEntityDbMapper::factory($container->get(FactoryInterface::class));
        $this->table = PostConstants::TABLE_NAME;
        $this->db = $container->get(MainConnection::class);
    }

}
