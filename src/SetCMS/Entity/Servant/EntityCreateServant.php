<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityHasByIdDAO;
use SetCMS\Entity\DAO\EntitySaveDAO;
use SetCMS\Entity;

abstract class EntityCreateServant implements ServantInterface
{

    public Entity $entity;

    public function serve(): void
    {
        $hasEntityById = $this->hasEntityById();
        $hasEntityById->id = $this->entity->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw $this->alreadyExistsException();
        }

        $saveEntity = $this->saveEntity();
        $saveEntity->entity = $this->entity;
        $saveEntity->serve();
    }

    abstract protected function alreadyExistsException(): \Exception;

    abstract protected function saveEntity(): EntitySaveDAO;

    abstract protected function hasEntityById(): EntityHasByIdDAO;
}
