<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Scope;

use SetCMS\Contract\Twigable;
use SetCMS\UUID;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\Session\DAO\SessionRetrieveByIdDAO;

class SessionPrivateReadScope extends SessionPrivateScope implements Twigable
{

    protected ?SessionEntity $entity = null;
    public UUID $id;

    public function to(object $object): void
    {
        if ($object instanceof SessionRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof SessionRetrieveByIdDAO) {
            $this->entity = $object->session;
        }
    }

    public function toArray(): array
    {
        return [
            'session' => $this->entity,
        ];
    }

}
