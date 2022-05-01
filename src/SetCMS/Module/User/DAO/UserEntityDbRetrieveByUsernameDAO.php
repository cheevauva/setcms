<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Core\Entity\DAO\EntityDbRetrieveByCriteriaDAO;

class UserEntityDbRetrieveByUsernameAndPasswordDAO extends EntityDbRetrieveByCriteriaDAO
{

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = PostEntityDbMapper::factory($container->get(FactoryInterface::class));
        $this->table = PostConstants::TABLE_NAME;
        $this->db = $container->get(MainConnection::class);
    }

}
