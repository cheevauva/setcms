<?php

declare(strict_types=1);

namespace Module\User\Wrapper;

use SetCMS\Entity\EntityBasic;
use Module\User\DAO\UserGetOneByCriteriaDAO;
use Module\User\Entity\UserEntity;
use SetCMS\UUID;
use SetCMS\View\View;
use UUA\DTO\SignedDTO;

class UserReadViewWrapper extends \UUA\Wrapper
{

    #[\Override]
    protected function onBefore(): void
    {
        $root = $this->rootUnit;

        if ($root instanceof View) {
            $entity = new SignedDTO('entity')->from($root);

            if (!$entity) {
                return;
            }

            $entity = EntityBasic::as($entity);

            new SignedDTO('assignedBy', $this->userById($entity->assignedBy))->to($root);
            new SignedDTO('createdBy', $this->userById($entity->createdBy))->to($root);
            new SignedDTO('modifiedBy', $this->userById($entity->modifiedBy))->to($root);
        }
    }

    protected function userById(UUID $uuid): UserEntity
    {
        $userById = UserGetOneByCriteriaDAO::new($this->container);
        $userById->id = $uuid;
        $userById->serve();

        return $userById->user;
    }

    #[\Override]
    protected function onAfter(): void
    {
        
    }
}
