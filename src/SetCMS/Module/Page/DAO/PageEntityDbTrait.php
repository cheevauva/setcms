<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use Psr\Container\ContainerInterface;
use DI\FactoryInterface;
use SetCMS\Module\Page\PageEntityDbMapper;
use SetCMS\Module\Page\PageConstants;
use SetCMS\Database\MainConnection;

trait PageEntityDbTrait
{

    public function __construct(ContainerInterface $container, FactoryInterface $factory)
    {
        $this->mapper = PageEntityDbMapper::make($factory);
        $this->table = PageConstants::TABLE_NAME;
        $this->db = $container->get(MainConnection::class);
    }

}
