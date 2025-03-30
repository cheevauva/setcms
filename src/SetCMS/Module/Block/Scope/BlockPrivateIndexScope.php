<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Scope;

use SetCMS\Module\Block\DAO\BlockRetrieveManyDAO;

class BlockPrivateIndexScope extends BlockPrivateScope
{

    protected array $entities = [];

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof BlockRetrieveManyDAO) {
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
