<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Scope;

use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\Session\Servant\SessionCreateServant;

class SessionPrivateCreateScope extends SessionPrivateScope
{

    protected ?SessionEntity $entity = null;
    public SessionPrivateSessionScope $session;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SessionCreateServant) {
            $this->entity = new SessionEntity;
            $this->session->to($this->entity);
            $object->session = $this->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'session' => $this->entity,
        ];
    }

}
