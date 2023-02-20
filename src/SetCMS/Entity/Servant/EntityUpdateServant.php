<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityHasByIdDAO;
use SetCMS\Entity\DAO\EntitySaveDAO;
use SetCMS\Entity;

abstract class EntityUpdateServant implements ServantInterface
{

    public Entity $entity;

    public function serve(): void
    {
        $hasById = $this->hasById();
        $hasById->id = $this->entity->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw $this->notFoundException();
        }

        $saveEntity = $this->save();
        $saveEntity->entity = $this->entity;
        $saveEntity->serve();
    }

    abstract protected function hasById(): EntityHasByIdDAO;

    abstract protected function save(): EntitySaveDAO;

    abstract protected function notFoundException(): \Exception;
}
