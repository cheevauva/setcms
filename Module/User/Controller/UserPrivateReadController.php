<?php

declare(strict_types=1);

namespace Module\User\Controller;

use SetCMS\UUID;
use Module\User\Servant\UserGetByIdServant;
use Module\User\Entity\UserEntity;

class UserPrivateReadController extends UserPrivateController
{

    protected UserEntity $user;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            UserGetByIdServant::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserGetByIdServant) {
            $this->user = $object->user;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserGetByIdServant) {
            $object->id = $this->id;
        }
    }
}
