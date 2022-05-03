<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use DI\FactoryInterface;
use SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\Module\Page\PageEntityDbMapper;

class PageEntityDbRetrieveByIdDAO extends EntityDbRetrieveByIdDAO
{

    public function __construct(FactoryInterface $factory)
    {
        $this->mapper = $factory->make(PageEntityDbMapper::class);
    }

}
