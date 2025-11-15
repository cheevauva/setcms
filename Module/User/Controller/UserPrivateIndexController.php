<?php

declare(strict_types=1);

namespace Module\User\Controller;

use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\Entity\UserEntity;
use Module\User\View\UserPrivateIndexView;

class UserPrivateIndexController extends UserPrivateController
{

    /**
     * @var UserEntity[]
     */
    protected array $users = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            UserRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPrivateIndexView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof UserPrivateIndexView) {
            $object->users = $this->users;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveManyByCriteriaDAO) {
            $this->users = $object->users;
        }
    }
}
