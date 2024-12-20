<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Module\Post\DAO\PostRetrieveManyDAO;

class PostPrivateIndexScope extends PostPrivateScope
{

    protected array $entities = [];

    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof PostRetrieveManyDAO) {
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
