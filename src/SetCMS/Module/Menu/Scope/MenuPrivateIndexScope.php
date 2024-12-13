<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Scope;

use SetCMS\Scope;
use SetCMS\Module\Menu\DAO\MenuRetrieveManyDAO;

class MenuPrivateIndexScope extends Scope
{

    protected array $entities = [];

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyDAO) {
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
