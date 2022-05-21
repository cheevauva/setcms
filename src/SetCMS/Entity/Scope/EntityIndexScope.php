<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

use SetCMS\Entity\DAO\EntityDbRetrieveManyByCriteriaDAO;

abstract class EntityIndexScope extends \SetCMS\Scope
{

    protected ?\Iterator $entities = null;

    public function from(object $object): void
    {
        if ($object instanceof EntityDbRetrieveManyByCriteriaDAO) {
            $this->entities = $object->entities;
        }
    }

    public function toArray(): array
    {
        return [
            'entities' => $this->entities,
        ];
    }

}
