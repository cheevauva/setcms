<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity\Servant;

use SetCMS\Core\ServantInterface;
use SetCMS\Core\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\Core\Entity\DAO\EntityDbSaveDAO;
use SetCMS\Core\Entity;

class EntityDeleteServant implements ServantInterface
{

    protected EntityDbRetrieveByIdDAO $retrieveById;
    protected EntityDbSaveDAO $save;
    public ?string $id = null;
    public Entity $entity;

    public function serve(): void
    {
        $this->retrieveById->id = $this->id ?? $this->entity->id;
        $this->retrieveById->serve();

        $this->entity = $this->retrieveById->entity;
        $this->entity->deleted = true;

        $this->save->entity = $this->entity;
        $this->save->serve();
    }

}
