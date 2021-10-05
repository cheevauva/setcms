<?php

namespace SetCMS\Module\Ordinary\OrdinaryModel;

use SetCMS\Module\Ordinary\OrdinaryEntity;

abstract class OrdinaryModelSave extends \SetCMS\Model
{

    public ?int $id = null;
    private ?OrdinaryEntity $entity = null;

    public function entity(?OrdinaryEntity $entity = null): ?OrdinaryEntity
    {
        if ($entity instanceof OrdinaryEntity) {
            $this->entity = $entity;
        }

        return $this->entity;
    }

    abstract public function prepareEntity();

    public function toArray(): array
    {
        return [
            'model' => $this,
            'entity' => $this->entity,
        ];
    }

}
