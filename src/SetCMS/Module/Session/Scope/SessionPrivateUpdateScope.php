<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Scope;

use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\Session\DAO\SessionRetrieveByIdDAO;
use SetCMS\Module\Session\Servant\SessionUpdateServant;

class SessionPrivateUpdateScope extends SessionPrivateScope
{

    protected ?SessionEntity $entity = null;
    public SessionPrivateSessionScope $session;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SessionRetrieveByIdDAO) {
            $this->entity = new SessionEntity;
            $this->session->to($this->entity);
            $object->id = $this->entity->id;
        }

        if ($object instanceof SessionUpdateServant) {
            $this->session->to($this->entity);
            $object->session = $this->entity;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

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
