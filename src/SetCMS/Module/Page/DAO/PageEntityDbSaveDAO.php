<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Core\Entity\DAO\EntityDbSaveDAO;
use SetCMS\Module\Page\PageEntityDbMapper;

class PageEntityDbSaveDAO extends EntityDbSaveDAO
{

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = $container->get(PageEntityDbMapper::class);
        $this->table = 'pages';
    }

}
