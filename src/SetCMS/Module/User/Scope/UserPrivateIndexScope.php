<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Module\User\DAO\UserRetrieveManyDAO;

class UserPrivateIndexScope extends UserPrivateScope
{
    protected ?\Iterator $entities = null;

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveManyDAO) {
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
