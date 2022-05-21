<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

use SetCMS\Entity\DAO\EntityDbRetrieveManyDAO;

abstract class EntityIndexScope extends \SetCMS\Scope
{

    protected ?\Iterator $entities = null;

    public function from(object $object): void
    {
        if ($object instanceof EntityDbRetrieveManyDAO) {
            $this->entities = $object->entities;
        }
    }

    public function toArray(): array
    {
        return [
            'entities' => iterator_to_array($this->entities),
        ];
    }

}
