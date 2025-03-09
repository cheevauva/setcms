<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\Module\User\DAO\UserRetrieveManyDAO;
use SetCMS\Attribute\ResponderPassProperty;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\User\Entity\UserEntity;

#[RequestMethod('GET')]
class UserPrivateIndexController extends UserPrivateController
{

    /**
     * @var array<UserEntity>
     */
    #[ResponderPassProperty]
    protected array $entities = [];

    #[\Override]
    protected function units(): array
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
