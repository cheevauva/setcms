<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Servant;

use DI\FactoryInterface;
use SetCMS\Core\Entity\Servant\EntityDeleteServant;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageEntityDbSaveDAO;

class PageEntityDeleteServant extends EntityDeleteServant
{

    public function __construct(FactoryInterface $factory)
    {
        $this->retrieveById = $factory->make(PageEntityDbRetrieveByIdDAO::class);
        $this->save = $factory->make(PageEntityDbSaveDAO::class);
    }

}
