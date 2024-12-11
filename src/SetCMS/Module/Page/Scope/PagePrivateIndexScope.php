<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\DAO\PageRetrieveManyDAO;

class PagePrivateIndexScope extends PagePrivateScope
{

    protected array $entities = [];

    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof PageRetrieveManyDAO) {
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
