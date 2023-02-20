<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Entity\DAO\EntitySaveDAO;
use SetCMS\Entity;
use SetCMS\UUID;

abstract class EntityDeleteServant implements ServantInterface
{

    public ?Entity $entity = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $retrieveById = $this->retrieveById();
        $retrieveById->id = $this->id ?? $this->entity->id;
        $retrieveById->serve();

        if (!$retrieveById->entity) {
            throw $this->notFoundException();
        }

        $entity = $retrieveById->entity;
        $entity->deleted = true;

        $save = $this->save();
        $save->entity = $entity;
        $save->serve();

        $this->entity = $entity;
    }

    abstract protected function retrieveById(): EntityRetrieveByIdDAO;

    abstract protected function save(): EntitySaveDAO;

    abstract protected function notFoundException(): \Exception;
}
