<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\Entity\DAO\EntityDbSaveDAO;
use SetCMS\Entity;
use SetCMS\UUID;

abstract class EntityDeleteServant implements ServantInterface
{

    protected EntityDbRetrieveByIdDAO $retrieveById;
    protected EntityDbSaveDAO $save;
    public ?UUID $id = null;
    public Entity $entity;

    public function serve(): void
    {
        $this->retrieveById->id = $this->id ?? $this->entity->id;
        $this->retrieveById->throwExceptions = true;
        $this->retrieveById->serve();

        $this->entity = $this->retrieveById->entity;
        $this->entity->deleted = true;

        $this->save->entity = $this->entity;
        $this->save->serve();
    }

}
