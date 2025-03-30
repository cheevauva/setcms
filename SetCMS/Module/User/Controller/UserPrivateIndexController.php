<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\Module\User\DAO\UserRetrieveManyDAO;
use SetCMS\Module\User\Entity\UserEntity;

class UserPrivateIndexController extends UserPrivateController
{

    /**
     * @var array<UserEntity>
     */
    protected array $entities = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            UserRetrieveManyDAO::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveManyDAO) {
            $this->entities = $object->entities;
        }
    }
}
