<?php

declare(strict_types=1);

namespace Module\User\Wrapper;

use Module\Basic\DAO\BasicEntityRetrieveByCriteriaDAO;
use Module\Basic\Entity\BasicEntity;
use Module\User\Servant\UserGetByIdServant;

class UserLazyLoadForBasicEntityWrapper extends \UUA\Wrapper
{

    #[\Override]
    protected function onBefore(): void
    {
        
    }

    #[\Override]
    protected function onAfter(): void
    {
        $unit = BasicEntityRetrieveByCriteriaDAO::as($this->rootUnit);

        foreach ($unit->entities as $entity) {
            $entity = BasicEntity::as($entity);
            $entity->withAttr('assignedBy', fn() => UserGetByIdServant::call($this, $entity->assignedBy)->entity);
            $entity->withAttr('createdBy', fn() => UserGetByIdServant::call($this, $entity->createdBy)->entity);
            $entity->withAttr('modifiedBy', fn() => UserGetByIdServant::call($this, $entity->modifiedBy)->entity);
        }
    }
}
