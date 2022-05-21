<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\ServantInterface;
use SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\Entity\DAO\EntityDbSaveDAO;
use SetCMS\Contract\Applicable;
use SetCMS\Entity;

abstract class EntitySaveServant implements ServantInterface
{

    protected EntityDbRetrieveByIdDAO $retrieveById;
    protected EntityDbSaveDAO $save;
    public Applicable $applier;
    public Entity $entity;
    public ?string $id = null;

    public function serve(): void
    {
        if (!empty($this->id)) {
            $this->retrieveById->id = $this->id;
            $this->retrieveById->throwExceptions = true;
            $this->retrieveById->serve();

            $this->entity = $this->retrieveById->entity;
        }
        
        $this->applier->apply($this->entity);

        $this->save->entity = $this->entity;
        $this->save->serve();
    }

}
