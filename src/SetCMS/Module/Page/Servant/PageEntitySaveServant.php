<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Servant;

use DI\FactoryInterface;
use SetCMS\Entity\Servant\EntitySaveServant;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageEntityDbSaveDAO;

class PageEntitySaveServant extends EntitySaveServant
{

    public function __construct(FactoryInterface $factory)
    {
        $this->retrieveById = $factory->make(PageEntityDbRetrieveByIdDAO::class);
        $this->save = $factory->make(PageEntityDbSaveDAO::class);
    }

}
