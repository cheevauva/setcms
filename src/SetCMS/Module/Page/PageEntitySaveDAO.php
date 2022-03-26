<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use Psr\Container\ContainerInterface;
use SetCMS\Core\Entity\DAO\EntitySaveDAO;
use SetCMS\Module\Page\PageEntityDbMapper;

class PageEntitySaveDAO extends EntitySaveDAO
{

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = $container->get(PageEntityDbMapper::class);
        $this->table = 'pages';
    }

}
