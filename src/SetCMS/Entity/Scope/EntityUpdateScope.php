<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

use SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\Entity\Servant\EntityUpdateServant;

abstract class EntityUpdateScope extends EntitySaveScope
{

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof EntityDbRetrieveByIdDAO) {
            $this->entity = $object->entity;
        }
    }

    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof EntityUpdateServant) {
            $this->to($this->entity);
            $object->entity = $this->entity;
        }
        
        if ($object instanceof EntityDbRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

}
