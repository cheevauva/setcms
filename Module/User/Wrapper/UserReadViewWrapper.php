<?php

declare(strict_types=1);

namespace Module\User\Wrapper;

use SetCMS\Entity\EntityBasic;
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

            $entity = EntityBasic::as($entity);

            new SignedDTO('assignedBy', UserGetByIdServant::call($this->container, $entity->assignedBy)->user)->to($root);
            new SignedDTO('createdBy', UserGetByIdServant::call($this->container, $entity->createdBy)->user)->to($root);
            new SignedDTO('modifiedBy', UserGetByIdServant::call($this->container, $entity->modifiedBy)->user)->to($root);
        }
    }

    #[\Override]
    protected function onAfter(): void
    {
        
    }
}
