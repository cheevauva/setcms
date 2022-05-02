<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\FactoryInterface;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;
use SetCMS\Module\Post\DAO\PostEntityDbSaveDAO;

class PostEntitySaveServant extends \SetCMS\Core\Entity\Servant\EntitySaveServant
{

    public function __construct(FactoryInterface $factory)
    {
        $this->entity = new \SetCMS\Module\Post\PostEntity;
        $this->retrieveById = $factory->make(PostEntityDbRetrieveByIdDAO::class);
        $this->save = $factory->make(PostEntityDbSaveDAO::class);
    }

}
