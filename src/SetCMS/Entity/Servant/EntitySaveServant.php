<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\Entity\DAO\EntityDbSaveDAO;
use SetCMS\Contract\Applicable;
use SetCMS\Entity;
use SetCMS\UUID;

abstract class EntitySaveServant implements ServantInterface
{

    public Applicable $applier;
    public Entity $entity;
    public ?UUID $id = null;

    public function serve(): void
    {
        $this->entity = $this->entity ?? $this->entity();

        if (!empty($this->id)) {
            $retrieveById = $this->retrieveEntityById(); 
            $retrieveById->id = $this->id;
            $retrieveById->throwExceptions = true;
            $retrieveById->serve();

            $this->entity = $retrieveById->entity;
        }

        $this->applier->apply($this->entity);

        $saveEntity = $this->saveEntity();
        $saveEntity->entity = $this->entity;
        $saveEntity->serve();
    }

    abstract protected function entity(): Entity;

    abstract protected function saveEntity(): EntityDbSaveDAO;

    abstract protected function retrieveEntityById(): EntityDbRetrieveByIdDAO;
}
