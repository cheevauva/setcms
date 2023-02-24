<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Contract\Twigable;
use SetCMS\Module\Post\DAO\PostRetrieveManyDAO;

class PostPrivateIndexScope extends PostPrivateScope implements Twigable
{

    protected ?\Iterator $entities = null;

    public function from(object $object): void
    {
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
