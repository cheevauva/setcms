<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityDbHasByIdDAO;
use SetCMS\Entity\DAO\EntityDbSaveDAO;
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
            throw new \Exception('Запись уже существует, необходимо использовать обновление');
        }

        $saveEntity = $this->saveEntity();
        $saveEntity->entity = $this->entity;
        $saveEntity->serve();
    }

    abstract protected function saveEntity(): EntityDbSaveDAO;

    abstract protected function hasEntityById(): EntityDbHasByIdDAO;
}
