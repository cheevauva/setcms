<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\FactoryInterface;
use SetCMS\Module\Post\DAO\PostEntityRetrieveByIdDAO;
use SetCMS\Module\Post\DAO\PostEntitySaveDAO;
use SetCMS\Module\Post\PostEntity;

class PostEntitySaveServant extends \SetCMS\Entity\Servant\EntitySaveServant
{

    public function __construct(FactoryInterface $factory)
    {
        $this->entity = new PostEntity;
        $this->retrieveById = $factory->make(PostEntityRetrieveByIdDAO::class);
        $this->save = $factory->make(PostEntitySaveDAO::class);
    }

}
