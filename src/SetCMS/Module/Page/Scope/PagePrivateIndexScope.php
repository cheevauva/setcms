<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Contract\Twigable;
use SetCMS\Module\Page\DAO\PageRetrieveManyDAO;

class PagePrivateIndexScope extends PagePrivateScope implements Twigable
{

    protected ?\Iterator $entities = null;

    public function from(object $object): void
    {
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
