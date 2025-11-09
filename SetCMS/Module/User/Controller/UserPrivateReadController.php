<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\UUID;
use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Entity\UserEntity;

class UserPrivateReadController extends UserPrivateController
{

    protected UserEntity $user;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            UserRetrieveManyByCriteriaDAO::class,
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

        if ($object instanceof UserRetrieveManyByCriteriaDAO) {
            $this->user = UserEntity::as($object->user);
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->limit = 1;
            $object->orThrow = true;
        }
    }
}
