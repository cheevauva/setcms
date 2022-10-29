<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityDbHasByIdDAO;
use SetCMS\Entity\DAO\EntityDbSaveDAO;
use SetCMS\Entity;

abstract class EntityUpdateServant implements ServantInterface
{

    public Entity $entity;

    public function serve(): void
    {
        $hasById = $this->hasEntityById();
        $hasById->id = $this->entity->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new \Exception('Запись для обновления не найдена');
        }

        $saveEntity = $this->saveEntity();
        $saveEntity->entity = $this->entity;
        $saveEntity->serve();
    }

    abstract protected function hasEntityById(): EntityDbHasByIdDAO;

    abstract protected function saveEntity(): EntityDbSaveDAO;
}
