<?php

declare(strict_types=1);

namespace Module\User\Wrapper;

use Module\Basic\Entity\BasicEntity;
use Module\User\Servant\UserGetByIdServant;
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

            $entity = BasicEntity::as($entity);

            $root->from(new SignedDTO('assignedBy', UserGetByIdServant::call($this->container, $entity->assignedBy)->user));
            $root->from(new SignedDTO('createdBy', UserGetByIdServant::call($this->container, $entity->createdBy)->user));
            $root->from(new SignedDTO('modifiedBy', UserGetByIdServant::call($this->container, $entity->modifiedBy)->user));
        }
    }

    #[\Override]
    protected function onAfter(): void
    {
        
    }
}
