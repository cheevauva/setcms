<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

use SetCMS\Entity;
use SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\UUID;

abstract class EntityReadScope extends \SetCMS\Scope
{

    protected ?Entity $entity = null;
    public UUID $id;

    public function to(object $object): void
    {
        if ($object instanceof EntityDbRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof EntityDbRetrieveByIdDAO) {
            $this->entity = $object->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'entity' => $this->entity,
        ];
    }

}
