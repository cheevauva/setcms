<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\Entity\DAO\EntityDbSaveDAO;
use SetCMS\ApplyInterface;
use SetCMS\Entity;
use SetCMS\Entity\EntityException;

class EntitySaveServant implements ServantInterface
{

    protected EntityDbRetrieveByIdDAO $retrieveById;
    protected EntityDbSaveDAO $save;
    public ApplyInterface $apply;
    public ?string $id = null;
    public Entity $entity;

    public function serve(): void
    {
        try {
            $this->retrieveById->id = $this->id ?? $this->entity->id;
            $this->retrieveById->serve();

            $this->entity = $this->retrieveById->entity;
        } catch (EntityException $ex) {
            // nothing do
        }

        $this->apply->apply($this->entity);

        $this->save->entity = $this->entity;
        $this->save->serve();
    }

}
