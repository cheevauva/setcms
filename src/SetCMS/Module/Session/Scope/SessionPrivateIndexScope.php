<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Scope;

use SetCMS\Contract\Twigable;
use SetCMS\Module\Session\DAO\SessionRetrieveManyDAO;

class SessionPrivateIndexScope extends SessionPrivateScope implements Twigable
{

    protected ?\Iterator $entities = null;

    public function from(object $object): void
    {
        if ($object instanceof SessionRetrieveManyDAO) {
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
